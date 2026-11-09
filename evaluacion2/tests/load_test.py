"""Carga reproducible para justificar ADR de REST vs gRPC/analítica.
Ejemplo: python tests/load_test.py --requests 200 --concurrency 10
Imprime latencia p95, throughput y errores. Medir CPU/memoria con docker stats.
"""
import argparse
import concurrent.futures
import statistics
import time
import httpx

def main():
    parser=argparse.ArgumentParser()
    parser.add_argument("--url",default="http://127.0.0.1:8000/api/v1/products")
    parser.add_argument("--requests",type=int,default=200)
    parser.add_argument("--concurrency",type=int,default=10)
    args=parser.parse_args()
    if not 1<=args.concurrency<=100 or not 1<=args.requests<=10000:
        parser.error("Límites: concurrencia 1..100, solicitudes 1..10000")
    def task(_):
        start=time.perf_counter()
        try:
            r=httpx.get(args.url,timeout=10)
            return (time.perf_counter()-start,r.status_code)
        except httpx.RequestError:
            return (time.perf_counter()-start,0)
    start=time.perf_counter()
    with concurrent.futures.ThreadPoolExecutor(max_workers=args.concurrency) as pool:
        results=list(pool.map(task,range(args.requests)))
    total=time.perf_counter()-start
    times=sorted(r[0]*1000 for r in results)
    p95=times[max(0,int(len(times)*0.95)-1)]
    errors=sum(code!=200 for _,code in results)
    print(f"Solicitudes: {len(results)}; concurrencia: {args.concurrency}")
    print(f"Duración: {total:.2f}s; throughput: {len(results)/total:.2f} req/s")
    print(f"Latencia p50: {statistics.median(times):.2f} ms; p95: {p95:.2f} ms")
    print(f"Errores: {errors} ({100*errors/len(results):.2f}%)")
if __name__=="__main__": main()
