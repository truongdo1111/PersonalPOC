# Explain how cache aside work

## Diagrams

### Flows

```mermaid
graph LR
    A[Application] -- 1 . read --> C[Cache]
    C -- 2 . cache miss --> A
    A -- 3 . query data --> D[Database]
    D -- 4 . return data --> A
    A -- 5 . write cache --> C
```

### Sequence

```mermaid
sequenceDiagram
    participant Client
    participant Application
    participant Cache
    participant Database
    Client ->>+ Application: Access to frequency data
    Application ->> Application: Get cache key by your own solution
    Application ->>+ Cache: Query data from cache by cache key
    Cache -->>- Application: Return data
    Application ->> Application: Check caching missing by your self
    alt cache is miss
        Application ->>+ Database: Query data from database
        Database -->>- Application: Return
        Application ->> Cache: write data to cache
    else
        Application -->>- Client: Return data
    end
```

## Explanation

- Firstly, The Application read data from cache. If Cache has data, it will return data to application and end these
  process.
- On other hand, if Cache hasn't data, it will return data null then application will directly query data from database.
- After returning data from database, the application might write these data to cache for next time accessing.

## Principles

- Lazy loading: Data is loaded into the cache only when it is requested by the application.

## Pros

- Easy to implement, flexible.
- Suitable for read-heavy systems: reduce read latency and increase throughput for database.

## Cons

- Depend on managing caching logic by your own solution. In other words, Cache-aside places caching logic within the
  application, thus you decide when to cache, when to invalidate caching data and how to handle cache misses.
- You might handle write caching by your own solution,
  therefore, if you don't do the right way and updates correctly this could lead your system has data inconsistencies.
