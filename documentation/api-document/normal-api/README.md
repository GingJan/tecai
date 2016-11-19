## Api文档说明

1.本文档为方便api消费端查阅api接口而写。

2.本目录下的文档全部为非REST风格的接口文档，请注意区分。

3.本文档约定：

3.1：基础URI为：http://tecai.zjien.com

3.2：接口文档里的 `GET /users` 代表使用 HTTP `GET` 方法请求 `/users`。

3.2：接口详细文档里的URI都是基于基础URI上的，如： `GET /users?page=2` 代表 `GET http://tecai.zjien.com/users?page=2`。

3.3：GET方法的所有请求字段都以查询字符串形式发送，也即都要写在URI上，以?开头，如： `GET /jobs?name=设计师&page=2`。

3.3.1：可以对资源进行过滤查询，过滤查询可进行模糊查询如： 模糊查询： `GET /jobs?name=工程师:like` ；精准查询 `GET /jobs?name=前端开发工程师`。

3.4：本文档里的每个接口详细文档会对该接口的请求参数和返回字段进行解释。

...

（未完待续...）