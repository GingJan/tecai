## Schools Api 学校接口

> Author zjien


### 获取全部学校
`GET /schools`

_请求字段_

字段 | 含义 | 是否必须 | 数据类型 | 备注
------------- | ---------------- | :-----------------: | ------------ | ------------------
name | 学校名 | N | string | 
level | 学校等级 | N | int | 985：10，211：20，重本：30，二本：40，三本：50
city | 所在城市 | N | string | 北京
address | 详细地址 | N | string | xxx街道xxx号
shortname | 学校拼音/英文缩写 | N | string | 如MIT
page | 当前页码 | N | int | 默认1
sorted_by | 根据哪个字段排序 | N | string | 如：sorted_by=created_at。默认根据id字段排序
order_by | 顺序 | N | string | 升序：ASC，降序：DESC
注意：不允许的字段会被忽略

_响应字段_

字段 | 含义 | 数据类型 | 备注
------------------- | --------------------- | :---------------------: | ---------------------
name | 学校名 | string | 
level | 学校等级 | int | 985：10，211：20，重本：30，二本：40，三本：50
city | 所在城市 | string |
address | 详细地址 | string | 
shortname | 学校拼音/英文缩写 | string | 
page | 当前页码 | int |

**响应实例：Response**
```json
{
  "data": [
    {
      "id": "1",
      "name": "五邑大学",
      "level": "40",
      "city": "江门",
      "address": "蓬江区",
      "shortname": "WYU"
    },
    {
      "id": "2",
      "name": "中山大学",
      "level": "10",
      "city": "广州",
      "address": "海珠区",
      "shortname": "SYSU"
    },...
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


### 获取某个学校
`GET /schools/{id}`

_请求字段_

字段 | 含义 | 是否必须 | 数据类型 | 备注
------------- | ---------------- | :-----------------: | ------------ | ------------------
id | 学校id | N/A | int | 需要写在URL上，如 `/schools/1` 获取id为1的学校

_响应字段_

字段 | 含义 | 数据类型 | 备注
--------------- | ---------------- | :-----------------: | ------------ | ------------------
id | 学校id | int |
name | 学校名 | string | 
level | 学校等级 | int | 985：10，211：20，重本：30，二本：40，三本：50
city | 所在城市 | string | 北京
address | 详细地址 | string | xxx街道xxx号
shortname | 学校拼音/英文缩写 | string | 如MIT

**响应示例：Response**
```json
{
  "data": {
    "id": "1",
    "name": "中山大学",
    "level": "10",
    "city": "广州",
    "address": "海珠区",
    "shortname": "SYSU"
  }
}
```


### 创建学校
`POST /schools`

_请求字段_

字段 | 含义 | 是否必须 | 数据类型 | 备注
------------- | ---------------- | :-----------------: | ------------ | ------------------
name | 学校名 | Y | string | 麻省理工
level | 学校等级 | Y | int | 985：10，211：20，重本：30，二本：40，三本：50
city | 所在城市 | Y | string | 北京
address | 详细地址 | Y | string | xxx街道xxx号
shortname | 学校拼音/英文缩写 | N | string | 如MIT

**响应示例：Response**
创建成功返回HTTP状态码： `201`
响应体： 无
响应头： `Location: BASE_URL/schools/{id}` 如： `Location: BASE_URL/schools/1`


### 更新某个学校
`PUT/PATCH /schools/{id}`

_请求字段_

字段 | 含义 | 是否必须 | 数据类型 | 备注
------------- | ---------------- | :-----------------: | ------------ | ------------------
id | 学校id | N/A | int | 需要写在URL上，如 `/schools/1` 更新id为1的学校
name | 学校名 | Y | string | 麻省理工
level | 学校等级 | Y | int | 985：10，211：20，重本：30，二本：40，三本：50
city | 所在城市 | Y | string | 北京
address | 详细地址 | Y | string | xxx街道xxx号
shortname | 学校拼音/英文缩写 | N | string | 如MIT
    
**响应示例：Response**
更新成功返回HTTP状态码： `204`
响应体： 无
响应头： 无


### 删除某个学校
`DELETE /schools/{id}`

_请求字段_

字段 | 含义 | 是否必须 | 数据类型 | 备注
------------- | ---------------- | :-----------------: | ------------ | ------------------
id | 学校id | N/A | int | 需要写在URL上，如 `/schools/1` 删除id为1的学校

**响应示例：Response**
删除成功返回HTTP状态码： `204`
响应体： 无
响应头： 无