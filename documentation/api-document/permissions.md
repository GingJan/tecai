## Permissions Api 权限接口

> Author zjien


### 获取全部权限
`GET /permissions`

_请求字段_

字段 | 含义 | 是否必须 | 数据类型 | 备注
------------- | ---------------- | :-----------------: | ------------ | ------------------
name | 权限名 | N | string | 如：create-company
verb | 动作 | N | string | 如：GET
uri | 权限对应的uri | N | string | 如：/roles
type | 资源访问级别 | N | string | 私人资源：10，角色资源：20，公开资源：30
status | 资源是否关闭访问 | N | bool | 开放：0，关闭：1
display_name | 权限显示的名字 | N | string | 如：Create-Company 
page | 当前页码 | N | int | 默认1
sorted_by | 根据哪个字段排序 | N | string | 如：sorted_by=created_at。默认根据id字段排序
order_by | 顺序 | N | string | 升序：ASC，降序：DESC
注意：不允许的字段会被忽略

_响应字段_

字段 | 含义 | 数据类型 | 备注
------------------- | --------------------- | :---------------------: | ---------------------
id | 权限id | int |
name | 权限名 | string | 如：create-company
verb | 动作 | string | 如：GET
uri | 权限对应的uri | string | 如：/roles
type | 资源访问级别 | string | 私人资源：10，角色资源：20，公开资源：30
status | 资源是否关闭访问 | bool | 开放：0，关闭：1
display_name | 权限显示的名字 | string | 如：Create-Company
description | 该权限的描述信息 | string | 如：the permission to create a company
created_at | 创建时间 | string/date | 2016-10-31 17:10:44
updated_at | 修改时间 | string/date | 2016-10-31 17:10:44

**响应实例：Response**
```json
{
  "data": [
    {
      "id": "1",
      "name": "get-all-admins",
      "verb": "GET",
      "uri": "/admins",
      "type": "30",
      "status": "0",
      "display_name": "Get-all-admins",
      "description": "This is get-all-admins permission",
      "created_at": "2016-11-04 14:14:15",
      "updated_at": "2016-11-04 14:14:15"
    },
    {
      "id": "2",
      "name": "get-one-admins",
      "verb": "GET",
      "uri": "/admins/{id}",
      "type": "30",
      "status": "0",
      "display_name": "Get-one-admins",
      "description": "This is get-one-admins permission",
      "created_at": "2016-11-04 14:14:15",
      "updated_at": "2016-11-04 14:14:15"
    },
    ...
  ],
  "meta": {
    "pagination": {
      "total": 3,
      "count": 3,
      "per_page": 15,
      "current_page": 1,
      "total_pages": 1,
      "links": []
    }
  }
}
```


### 获取某个权限
`GET /permissions/{id}`

_请求字段_

字段 | 含义 | 是否必须 | 数据类型 | 备注
------------- | ---------------- | :-----------------: | ------------ | ------------------
id | 权限id | Y | int | 需要写在URL上，如 `/permissions/1` 获取id为1的权限，id与name只可选其一
name | 权限名 | Y | string | 需要写在URL上，如 `/permissions/create-company` 获取名为create-company的权限，id与name只可选其一

_响应字段_

字段 | 含义 | 数据类型 | 备注
--------------- | ---------------- | :-----------------: | ------------ | ------------------
id | 权限id | int |
name | 权限名 | string | 如：create-admins
verb | 动作 | string | 如：GET
uri | 权限对应的uri | string | 如：/roles
type | 资源访问级别 | string | 私人资源：10，角色资源：20，公开资源：30
status | 资源是否关闭访问 | bool | 开放：0，关闭：1
display_name | 权限显示的名字 | string | 如：Create-admins
description | 该权限的描述信息 | string | 如：This is create-admins permission
created_at | 创建时间 | string/date | 2016-10-31 17:10:44
updated_at | 修改时间 | string/date | 2016-10-31 17:10:44

**响应示例：Response**
```json
{
  "data": {
    "id": "3",
    "name": "create-admins",
    "verb": "POST",
    "uri": "/admins",
    "type": "30",
    "status": "0",
    "display_name": "Create-admins",
    "description": "This is create-admins permission",
    "created_at": "2016-11-04 14:14:15",
    "updated_at": "2016-11-04 14:14:15"
  }
}
```


### 创建权限
`POST /permissions`

_请求字段_

字段 | 含义 | 是否必须 | 数据类型 | 备注
------------- | ---------------- | :-----------------: | ------------ | ------------------
name | 权限名 | Y | string | 
verb | 动作 | Y | string | 如：GET
uri | 权限对应的uri | Y | string | 如：/roles。如果是单个资源，则为/roles/{id}
type | 资源访问级别 | N | string | 私人资源：10，角色资源：20，公开资源：30，默认公开资源。
status | 资源是否关闭访问 | N | bool | 开放：0，关闭：1，默认开放
display_name | 显示权限名 | N | string |
description | 权限描述信息 | N | string |

**响应示例：Response**
创建成功返回HTTP状态码： `201`
响应体： 无
响应头： `Location: BASE_URL/permissions/{id}` 如： `Location: BASE_URL/permissions/1`


### 更新某个权限
`PUT/PATCH /permissions/{id}`

_请求字段_

字段 | 含义 | 是否必须 | 数据类型 | 备注
------------- | ---------------- | :-----------------: | ------------ | ------------------
name | 权限名 | Y | string | 
verb | 动作 | Y | string | 如：GET
uri | 权限对应的uri | Y | string | 如：/roles。如果是单个资源，则为/roles/{id}
type | 资源访问级别 | N | string | 私人资源：10，角色资源：20，公开资源：30，默认公开资源。
status | 资源是否关闭访问 | N | bool | 开放：0，关闭：1，默认开放
display_name | 显示权限名 | N | string |
description | 权限描述信息 | N | string |
    
**响应示例：Response**
删除成功返回HTTP状态码： `204`
响应体： 无
响应头： 无


### 删除某个权限
`DELETE /permissions/{id}`

_请求字段_

字段 | 含义 | 是否必须 | 数据类型 | 备注
------------- | ---------------- | :-----------------: | ------------ | ------------------
id | 权限id | Y | int | 需要写在URL上，如 `/permissions/1` 删除id为1的权限

**响应示例：Response**
删除成功返回HTTP状态码： `204`
响应体： 无
响应头： 无