## Roles Api 角色接口

> Author zjien


### 获取全部角色
`GET /roles`

请求字段
字段 | 含义 | 是否必须 | 数据类型 | 备注
------------- | ---------------- | :-----------------: | ------------ | ------------------
name | 角色名 | N | string | 如：admin
display_name | 角色显示的名字 | N | string | 如：Platform-Administrator 
page | 当前页码 | N | int | 默认1
sorted_by | 根据哪个字段排序 | N | string | 如：sorted_by=created_at。默认根据id字段排序
order_by | 顺序 | N | string | 升序：ASC，降序：DESC
注意：不允许的字段会被忽略

响应字段
字段 | 含义 | 数据类型 | 备注
------------------- | --------------------- | :---------------------: | ---------------------
id | 角色id | int |
name | 角色名 | string | 如：admin
display_name | 角色显示的名字 | string | 如：Platform-Administrator
description | 该角色的描述信息 | string | 如：the guy to admin the platform
created_at | 创建时间 | string/date | 2016-10-31 17:10:44
updated_at | 修改时间 | string/date | 2016-10-31 17:10:44

** 响应实例：Response **
```json
{
  "data": [
    {
      "id": "1",
      "name": "user",
      "display_name": "platform Admin",
      "description": "the guy to admin the platform",
      "created_at": "2016-10-31 17:10:44",
      "updated_at": "2016-10-31 17:10:44"
    },
    {
      "id": "2",
      "name": "admin",
      "display_name": "platform Admin",
      "description": "the guy to admin the platform",
      "created_at": "2016-10-31 17:11:28",
      "updated_at": "2016-10-31 17:11:28"
    }
  ],
  "meta": {
    "pagination": {
      "total": 2,
      "count": 2,
      "per_page": 15,
      "current_page": 1,
      "total_pages": 1,
      "links": []
    }
  }
}
```


### 获取某个角色
`GET /roles/{id}`

请求字段
字段 | 含义 | 是否必须 | 数据类型 | 备注
------------- | ---------------- | :-----------------: | ------------ | ------------------
id | 角色id | Y | int | 需要写在URL上，如 `/roles/1` 获取id为1的角色，id与name只可选其一
name | 角色名 | Y | string | 需要写在URL上，如 `/roles/user` 获取名为user的角色，id与name只可选其一
expand | 是否获取关联对象 | N | bool | 是：1，否：0，默认否。如果为是，则返回的role对象里包含有与它关联的其他对象，下面的示例数据以expand=1为例。 

响应字段
字段 | 含义 | 数据类型 | 备注
--------------- | ---------------- | :-----------------: | ------------ | ------------------
id | 角色id | int |
name | 角色名 | string | 如：admin
display_name | 角色显示的名字 | string | 如：Platform-Administrator
description | 该角色的描述信息 | string | 如：the guy to admin the platform
created_at | 创建时间 | string/date | 2016-10-31 17:10:44
updated_at | 修改时间 | string/date | 2016-10-31 17:10:44

** 响应示例：Response **
```json
{
  "data": {
    "id": "2",
    "name": "admin",
    "display_name": "platform Admin",
    "description": "the guy to admin the platform",
    "created_at": "2016-11-04 14:56:53",
    "updated_at": "2016-11-04 14:56:53",
    "permissions": [
      {
        "id": "16",
        "name": "get-all-clients",
        "verb": "GET",
        "uri": "/clients",
        "type": "30",
        "status": "0",
        "display_name": "Get-all-clients",
        "description": "This is get-all-clientspermission",
        "created_at": "2016-11-04 14:14:15",
        "updated_at": "2016-11-04 14:14:15",
        "pivot": {
          "role_id": "2",
          "permission_id": "16"
        }
      },
      {
        "id": "17",
        "name": "get-one-clients",
        "verb": "GET",
        "uri": "/clients/{id}",
        "type": "30",
        "status": "0",
        "display_name": "Get-one-clients",
        "description": "This is get-one-clientspermission",
        "created_at": "2016-11-04 14:14:15",
        "updated_at": "2016-11-04 14:14:15",
        "pivot": {
          "role_id": "2",
          "permission_id": "17"
        }
      },
      ...
    ]
  }
}
```


### 创建角色
`POST /roles`

字段 | 含义 | 是否必须 | 数据类型 | 备注
------------- | ---------------- | :-----------------: | ------------ | ------------------
name | 角色名 | Y | string |
permission | 对应的权限id | N | int/array | 可以是id数组如： `[1,2,3]` ，也可以是单个id
display_name | 显示角色名 | N | string |
description | 角色描述信息 | N | string |


** 响应示例：Response **
创建成功返回HTTP状态码： `201`
响应体： 无
响应头： `Location: BASE_URL/roles/{id}` 如： `Location: BASE_URL/roles/1`



### 更新某个角色
`PUT/PATCH /roles/{id}`

字段 | 含义 | 是否必须 | 数据类型 | 备注
------------- | ---------------- | :-----------------: | ------------ | ------------------
name | 角色名 | Y | string | 
permission | 对应的权限id | N | int/array | 可以是id数组如： `[1,2,3]` ，也可以是单个id
display_name | 显示角色名 | N | string |
description | 角色描述信息 | N | string |
    
** 响应示例：Response **
删除成功返回HTTP状态码： `204`
响应体： 无
响应头： 无


### 删除某个角色
`DELETE /roles/{id}`

请求字段
字段 | 含义 | 是否必须 | 数据类型 | 备注
------------- | ---------------- | :-----------------: | ------------ | ------------------
id | 角色id | Y | int | 需要写在URL上，如 `/roles/1` 删除id为1的角色

删除成功返回HTTP状态码： `204`
响应体： 无
响应头： 无