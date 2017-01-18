消息有三种分类：

公告 Announce
提醒 Remind
私信 Message

## 提醒的语言分析
   
分析提醒有下面的方式：

> 「谁对一样属于谁的事物做了什么操作」
> 「someone do something in someone's something」

someone = 提醒的触发者，或者发送者，标记为sender
do something = 提醒的动作，评论、喜欢、关注都属于一个动作，标记为action
something = 提醒的动作作用对象，这就具体到是哪一篇文章，标记为target,targetType
someone's = 提醒的动作作用对象的所有者，标记为targetOwner

一则订阅有以下三个核心属性：

订阅的目标 target
订阅的目标类型 targetType
订阅的动作 action

## 订阅

*一则订阅有以下三个核心属性*：

- 订阅的目标 target
- 订阅的目标类型 targetType
- 订阅的动作 action

根据不同的订阅原因会有不同的订阅动作，譬如：

我喜欢了一篇文章，和我发布了一篇文章，订阅的动作可能不一样。
喜欢了一篇文章，我希望我订阅这篇文章更新、评论的动作。
而发布了一篇文章，我希望我只是订阅这篇文章的评论动作。

这时候就需要多一个参数：subscribReason
不同的subscribReason，对应着一个动作数组，
subscribReason = 喜欢，对应着 actions = [更新，评论]
subscribReason = 发布，对应着 actions = [评论]

## 五个实体
1. 用户消息队列 UserNotify
2. 用户 User
3. 订阅 Subscription
4. 订阅设置 SubscriptionConfig
5. 消息 Notify
    - 通告 Announce
    - 提醒 Remind
    - 信息 Message
    
## 表设计

