# Caching technical

## Definition - WHAT - WHY?

### What?

- A go-to solutions whenever you need to speed up your web application
- A buffering technical where we store the frequently accessed data in temporary memory.

### Why?

This brings several benefits for your application/

#### Briefly

- Reduce workload for our application, server, or database
- Reduce latency when you connect to server to retrieve data.

#### Details

+ By using caching, you get data that is frequently accessed from buffering memory instead of retrieving that from
  server or
  database, thus it help us **improve application performance by reducing latency from connections**.
+ Reduce database cost: Like me told it before that reducing connections to our database allows we decrease cost if the
  storage charges are per throughput.
+ Reduce the load on server and save it from slower performance, because it redirects the specific part of read load
  from BE database to in-memory caching layer. This lead to saving the system from crashing at times of traffic
  overload.

## How many levels of caching?

### Edge Caching or CDN

A CDN is used to cache static assets in geographically distributed servers.

```mermaid
graph LR
    U[User] -- Request --> CDN[CDN]
    CDN -- Response --> U
    CDN --> PS[Processing Server]
    PS --> CDN
    PS --> S[Storage]
    S --> PS
```

We have several CDN services, such as:

+ AWS CloudFront
+ Cloudflare CDN

### Database caching

Native caching algorithms used by any database to optimize reads and writes. It can be used with all types of data
stores

### Client Side Caching or Browser caching

When you set cache expiry to HTTP response headers, Browsers will base on this to cache responses in client side.

### Server side caching

T.B.D

## Server Caching patterns - HOW TO IMPLEMENT?

- [READ - Cache Aside](./cache-aside/HOW-IT-WORK.MD)
- [READ - Cache Through](.)
- [WRITE - Write through](.)
- [WRITE - Write behind](.)

## Disadvantages // Trade-offs

T.B.D

## References

- [5 caching mechanisms](https://hackernoon.com/5-caching-mechanisms-to-speed-up-your-application)
- [Caching technicals](https://medium.com/@aggarwalapurva89/different-caching-techniques-660ad8d97a8a)
