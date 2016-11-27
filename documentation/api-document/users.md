## Users Api 用户接口

> Author zjien


### 获取全部用户
`GET /users`

_请求字段_

字段 | 含义 | 是否必须 | 数据类型 | 备注
------------- | ---------------- | :-----------------: | ------------ | ------------------
username | 用户昵称 | N | string | 
email | 邮箱 | N | string | 
phone | 电话 | N | string | 
age | 年龄 | N | int |
sex | 性别 | N | enum | 女：0，男：1
school_level | 学校级别 | N | 985：10，211：20，重本：30，二本：40，三本：50
school | 毕业学校 | N | string |
collage | 学院 | N | string |
major | 专业 | N | string |
native | 籍贯 | N | string |
province | 所在省份 | N | string |
city | 所在城市 | N | string |
address | 详细地址 | N | string |
wants_job_id | 意向工作id | N | int |
wants_job_name | 意向工作 | N | string |
page | 当前页码 | N | int | 默认1
sorted_by | 根据哪个字段排序 | N | string | 如：sorted_by=created_at。默认根据id字段排序
order_by | 顺序 | N | string | 升序：ASC，降序：DESC
注意：不允许的字段会被忽略

_响应字段_

字段 | 含义 | 数据类型 | 备注
------------------- | --------------------- | :---------------------: | ---------------------
id | 用户id | int |
account | 账号 | string |
username | 用户昵称 | string | 默认与account相同
realname | 真实姓名 | stirng |
email | 邮箱 | string | 长度31位
phone | 电话 | string | 长度11位
age | 年龄 | int |
sex | 性别 | enum | 女：0，男：1
school | 毕业学校 | string |
collage | 学院 | string |
major | 专业 | string |
native | 籍贯 | string |
province | 所在省份 | string |
city | 所在城市 | string |
address | 详细地址 | string |
wants_job_name | 意向工作 | string |
wants_job_id | 意向工作的id | int |
page | 当前页码 | int | 默认1
last_login_at | 上次登陆时间 | string/date | 2016-10-31 17:10:44
last_login_ip | 上次登陆IP | string | 179.29.39.10
created_at | 创建时间 | string/date | 2016-10-31 17:10:44
updated_at | 修改时间 | string/date | 2016-10-31 17:10:44

**响应实例：Response**
```json
{
  "data": [
    {
      "id": "1",
      "account": "alohoa1",
      "username": "tester1",
      "realname": "小明",
      "email": "tester1@qq.com",
      "phone": "13168732781",
      "age": "20",
      "sex": "1",
      "school_level": "2",
      "school": "麻省理工",
      "college": "计算机",
      "major": "计算机科学",
      "id_card": "228736447637288839",
      "native": "珠海",
      "province": "广东",
      "city": "广州",
      "address": "天河区珠江新城",
      "wants_job_id": "1",
      "wants_job_name": "PHP",
      "last_login_at": "2016-11-02 18:43:49",
      "last_login_ip": "127.0.0.1",
      "created_at": "2016-11-02 18:43:50",
      "updated_at": "2016-11-02 18:43:50"
    },
    {
      "id": "2",
      "account": "teste2",
      "username": "hahahahah2",
      "realname": "小李",
      "email": "asfsadasd2@qq.com",
      "phone": "13168732782",
      "age": "20",
      "sex": "1",
      "school_level": "2",
      "school": "麻省理工",
      "college": "计算机",
      "major": "CS",
      "id_card": "228736447637288839",
      "native": "china",
      "province": "广东",
      "city": "广州",
      "address": "joiafsdjfoja",
      "wants_job_id": "1",
      "wants_job_name": "PHP",
      "last_login_at": "2016-11-02 18:45:04",
      "last_login_ip": "127.0.0.1",
      "created_at": "2016-11-02 18:45:04",
      "updated_at": "2016-11-02 18:45:04"
    },...
  ],
  "meta": {
    "pagination": {
      "total": 4,
      "count": 4,
      "per_page": 15,
      "current_page": 1,
      "total_pages": 1,
      "links": []
    }
  }
}
```


### 获取某个用户
`GET /users/{id}`

_请求字段_

字段 | 含义 | 是否必须 | 数据类型 | 备注
------------- | ---------------- | :-----------------: | ------------ | ------------------
id | 用户id | N/A | int | 需要写在URL上，如 `/users/1` 获取id为1的用户，id与account只可选其一
account | 账号 | N/A | string | 需要写在URL上，如 `/users/alohoal` 获取名为alohoal的用户，id与account只可选其一

_响应字段_

字段 | 含义 | 数据类型 | 备注
--------------- | ---------------- | :-----------------: | ------------ | ------------------
id | 用户id | int |
account | 账号 | string |
username | 用户昵称 | string | 默认与account相同
realname | 真实姓名 | stirng |
email | 邮箱 | string | 长度31位
phone | 电话 | string | 长度11位
age | 年龄 | int |
sex | 性别 | enum | 女：0，男：1
school | 毕业学校 | string |
collage | 学院 | string |
major | 专业 | string |
native | 籍贯 | string |
province | 所在省份 | string |
city | 所在城市 | string |
address | 详细地址 | string |
wants_job_name | 意向工作 | string |
wants_job_id | 意向工作的id | int |
page | 当前页码 | int | 默认1
last_login_at | 上次登陆时间 | string/date | 2016-10-31 17:10:44
last_login_ip | 上次登陆IP | string | 179.29.39.10
created_at | 创建时间 | string/date | 2016-10-31 17:10:44
updated_at | 修改时间 | string/date | 2016-10-31 17:10:44

**响应示例：Response**
```json
{
  "data": {
    "id": "1",
    "account": "alohoal",
    "username": "tester1",
    "realname": "小明",
    "email": "tester1@qq.com",
    "phone": "13168732781",
    "age": "20",
    "sex": "1",
    "school_level": "2",
    "school": "麻省理工",
    "college": "计算机",
    "major": "计算机科学",
    "id_card": "228736447637288839",
    "native": "珠海",
    "province": "广东",
    "city": "广州",
    "address": "joiafsdjfoja",
    "wants_job_id": "1",
    "wants_job_name": "PHP",
    "last_login_at": "2016-11-02 18:43:49",
    "last_login_ip": "127.0.0.1",
    "created_at": "2016-11-02 18:43:50",
    "updated_at": "2016-11-02 18:43:50"
  }
}
```


### 创建用户
`POST /users`

_请求字段_

字段 | 含义 | 是否必须 | 数据类型 | 备注
------------- | ---------------- | :-----------------: | ------------ | ------------------
account | 账号 | Y | string |
password | 密码 | Y | string |
realname | 真实姓名 | Y | string |
username | 用户昵称 | N | string | 默认与account相同
email | 邮箱 | Y | string | 长度31位
phone | 电话 | N | string | 长度11位
age | 年龄 | N | int |
sex | 性别 | N | enum | 女：0，男：1
school | 毕业学校 | N | string |
collage | 学院 | N | string |
major | 专业 | N | string |
native | 籍贯 | N | string |
province | 所在省份 | N | string |
city | 所在城市 | N | string |
address | 详细地址 | N | string |
wants_job_id | 意向工作的id | N | string |
wants_job_name | 意向工作 | N | string |

**响应示例：Response**
创建成功返回HTTP状态码： `201`
响应体： 无
响应头： `Location: BASE_URL/users/{id}` 如： `Location: BASE_URL/users/1`


### 更新某个用户
`PUT/PATCH /users/{id}`

_请求字段_

字段 | 含义 | 是否必须 | 数据类型 | 备注
------------- | ---------------- | :-----------------: | ------------ | ------------------
id | 用户id | N/A | int | 需要写在URL上，如 `/users/1` 更新id为1的用户，id与account只可选其一
account | 账号 | N/A | string | 需要写在URL上，如 `/users/alohoal` 更新账号为alohoal的用户，id与account只可选其一
password | 密码 | N/A | string | 密码更新请查看password接口文档
username | 用户昵称 | Y | string | 默认与account相同
realname | 真实姓名 | Y | string |
email | 邮箱 | Y | string | 长度31位
phone | 电话 | N | string | 长度11位
age | 年龄 | N | int |
sex | 性别 | N | enum | 女：0，男：1
school | 毕业学校 | N | string |
collage | 学院 | N | string |
major | 专业 | N | string |
native | 籍贯 | N | string |
province | 所在省份 | N | string |
city | 所在城市 | N | string |
address | 详细地址 | N | string |
wants_job_id | 意向工作的id | N | string |
wants_job_name | 意向工作 | N | string |
    
**响应示例：Response**
删除成功返回HTTP状态码： `204`
响应体： 无
响应头： 无


### 删除某个用户
`DELETE /users/{id}`

_请求字段_

字段 | 含义 | 是否必须 | 数据类型 | 备注
------------- | ---------------- | :-----------------: | ------------ | ------------------
id | 用户id | N/A | int | 需要写在URL上，如 `/users/1` 删除id为1的用户，id与account只可选其一
account | 账号 | N/A | string | 需要写在URL上，如 `/users/alohoal` 删除账号为alohoal的用户，id与account只可选其一

**响应示例：Response**
删除成功返回HTTP状态码： `204`
响应体： 无
响应头： 无