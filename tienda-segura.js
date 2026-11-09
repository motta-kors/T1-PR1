"use strict";
const BASE = "http://localhost:8000/api/v1";
let token = null;
const $ = id => document.getElementById(id);
const status = message => { $("estado").textContent = message; };
async function api(path, method="GET", body=null) {
  const headers = {};
  if (body !== null) headers["Content-Type"] = "application/json";
  if (token) headers.Authorization = "Bearer " + token;
  const response = await fetch(BASE + path, {method, headers, body: body === null ? undefined : JSON.stringify(body)});
  const data = await response.json();
  if (!response.ok) throw new Error(typeof data.detail === "string" ? data.detail : "Error HTTP " + response.status);
  return data;
}
function formData(form) {return Object.fromEntries(new FormData(form).entries());}
function element(tag,text,className="") {
  const el=document.createElement(tag);
  el.textContent=text;
  if (className) el.className=className;
  return el;
}
async function catalogo() {
  try {
    const products=await api("/products");
    $("catalogo").replaceChildren();
    for (const product of products) {
      const col=element("div","","col-md-6");
      const card=element("div","","card h-100 text-dark");
      const body=element("div","","card-body");
      body.append(element("h3",product.name,"h5"),element("p","$"+product.price.toLocaleString("es-CL")+" · Stock: "+product.stock));
      const button=element("button","Pedir unidad","btn btn-success");
      button.disabled=product.stock<1;
      button.addEventListener("click",()=>pedir(product.id));
      body.append(button);card.append(body);col.append(card);$("catalogo").append(col);
    }
    if(!products.length)$("catalogo").append(element("p","Aún no hay productos. Un administrador debe agregarlos."));
    status("Catálogo cargado.");
  } catch (err) { status("No se pudo obtener el catálogo: "+err.message); }
}
async function pedir(id) {
  if (!token) {status("Primero inicia sesión.");return;}
  try {
    const order=await api("/orders","POST",{product_id:id,quantity:1});
    const payment=await api("/payments/"+order.id,"POST",{});
    status("Pedido creado por $"+order.total.toLocaleString("es-CL")+". Pago "+payment.status+" (sandbox, sin cobro real).");
    await Promise.all([catalogo(),pedidos()]);
  } catch(err){status("No se pudo crear el pedido: "+err.message);}
}
async function pedidos() {
  $("pedidos").replaceChildren();
  if(!token){$("pedidos").append(element("li","Inicia sesión para ver tus pedidos.","list-group-item"));return;}
  try{
    const result=await api("/graphql","POST",{query:"query { myOrders { id quantity total status product { name } } }"});
    if(result.errors)throw new Error(result.errors[0].message);
    for(const o of result.data.myOrders){
      const li=element("li",(o.product?.name || "Producto no disponible")+" · "+o.quantity+" u. · $"+o.total+" · "+o.status,"list-group-item");
      if(o.status==="pending"){
        const cancel=element("button","Anular","btn btn-sm btn-outline-danger ms-2");
        cancel.addEventListener("click",async()=>{try{await api("/orders/"+o.id+"/cancel","POST",{});await Promise.all([pedidos(),catalogo()]);}catch(err){status(err.message);}});
        li.append(cancel);
      }
      $("pedidos").append(li);
    }
    if(!result.data.myOrders.length)$("pedidos").append(element("li","Sin pedidos.","list-group-item"));
  }catch(err){status("Error consultando pedidos: "+err.message);}
}
$("registro").addEventListener("submit",async event=>{
  event.preventDefault();
  try{await api("/auth/register","POST",formData(event.target));status("Cuenta creada. Ahora inicia sesión.");event.target.reset();}
  catch(err){status("Registro: "+err.message);}
});
$("login").addEventListener("submit",async event=>{
  event.preventDefault();
  try{const result=await api("/auth/login","POST",formData(event.target));token=result.access_token;event.target.reset();status("Sesión iniciada.");await pedidos();}
  catch(err){status("Acceso: "+err.message);}
});
$("salir").addEventListener("click",async()=>{try{if(token)await api("/auth/logout","POST",{});}catch(err){}finally{token=null;status("Sesión cerrada.");await pedidos();}});
$("producto").addEventListener("submit",async event=>{
  event.preventDefault();
  const data=formData(event.target);
  try{
    await api("/products","POST",{name:data.name,price:Number(data.price),stock:Number(data.stock),active:true});
    event.target.reset();await catalogo();
  }catch(err){status("Administración: "+err.message);}
});
$("recargar").addEventListener("click",pedidos);
catalogo();pedidos();
