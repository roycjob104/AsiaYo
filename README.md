## SOLID 原則與設計模式

### SOLID 原則

- **單一職責原則 (Single Responsibility Principle)**: 各個類別負責單一的職責，例如 `OrderService` 處理訂單邏輯，`OrderCurrencyStrategyResolverService` 處理貨幣策略。
- **開放封閉原則 (Open/Closed Principle)**: 系統設計時可以擴展新貨幣而不修改現有程式碼，透過貨幣策略來實現。
- **里氏替換原則 (Liskov Substitution Principle)**: 使用貨幣策略模式時，每個貨幣策略可以替換或擴展，不會影響程式運行。
- **介面隔離原則 (Interface Segregation Principle)**: 將不同的貨幣處理邏輯隔離在不同策略中，各自負責不同貨幣的儲存邏輯。
- **依賴反轉原則 (Dependency Inversion Principle)**: `OrderService` 不直接依賴具體的貨幣實現，而是依賴 `OrderCurrencyStrategyResolverService` 來解決貨幣儲存方式。

### 設計模式

- **策略模式 (Strategy Pattern)**: 透過 `OrderCurrencyStrategyResolverService` 決定使用哪種貨幣策略，根據不同貨幣將訂單存入不同的資料表。
- **事件驅動模式 (Event-Driven Pattern)**: 當建立訂單時，觸發 `OrderCreated` 事件，由監聽器處理訂單資料存儲的邏輯。


## 其他說明
資料庫的設計概念是基於orders為主，然後多型關聯(morphTo)到不同的貨幣(orders_twd, orders_usd, orders_jpy, orders_rmb, orders_myr 使用 MorphMany)，主要是讓訂單為唯一的Key，且可以處理不同tables(貨幣)。
