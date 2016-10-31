## Corporations Api 企业/公司接口

> Author zjien


### 获取全部企业/公司
`GET /corporations`

请求字段
字段 | 含义 | 是否必须 | 数据类型 | 备注
------------- | ---------------- | :-----------------: | ------------ | ------------------
legal_person_id | 法人id | N | int |
legal_person_name | 法人名字 | N | string |
name | 公司名字 | N | string | 
city | 公司所在城市 | N | string |
address | 公司详细地址 | N | string | 
business | 公司所经营的业务 | N | string |
industry | 公司所属行业 | N | string |
financing | 融资情况 | N | string | 如：种子轮，天使轮，A、B、C、D、E轮，不需要融资
status | 当前状态 | N | int | 审核中/待审核：10，正常/审核通过:20，禁止（从正常转为禁止）：30，审核不通过：40
staff_num | 员工数量 | N | int |
corporation_type | 公司类型 | N | string | 上市企业，大型企业，中小型企业，初创
tag_name | 标签名 | N | string | 福利好，美女帅哥多，假期多...
tag_id | 标签id | N | int | 与标签名对应
phone | 公司联系电话 | N | string |
email | 公司邮箱 | N | string |
is_listing | 是否上市 | N | bool | 是：1，否：0 
is_authentication | 公司是否被认证 | N | bool | 是：1，否：0 
is_shown | 是否显示 | N | bool | 是：1，否：0 
page | 当前页码 | N | int | 默认1
sorted_by | 根据哪个字段排序 | N | string | 如：sorted_by=created_at。默认根据id字段排序
order_by | 顺序 | N | string | 升序：ASC，降序：DESC
注意：不允许的字段会被忽略

响应字段
字段 | 含义 | 数据类型 | 备注
------------------- | --------------------- | :---------------------: | ---------------------
id | 公司id | int |
legal_person_id | 法人id | string | 
legal_person_name | 法人名字 | string | 
name | 公司名字 | string | 
logo_img | logo的URL | string |
city | 公司所在城市 | string |
address | 公司详细地址 | string | 
business | 公司所经营的业务 | string |
industry | 公司所属行业 | string |
financing | 融资情况 | string | 如：种子轮，天使轮，A，B，C，D，E轮，不需要融资
status | 当前状态 | int | 10：审核中/待审核，20：正常/审核通过，30：禁止（从正常转为禁止），40：审核不通过
staff_num | 员工数量 | int |
corporation_type | 公司类型 | string | 上市企业，大型企业，中小型企业，初创
tag_name | 标签名 | string | 福利好，美女帅哥多，假期多...
tag_id | 标签id | int | 与标签名对应
phone | 公司联系电话 | string |
email | 公司邮箱 | string |
official_website | 公司官网 | stirng |
intro | 公司简介 | string |
others | 其他说明 | string |
is_listing | 是否上市 | bool | 1：是，0：否 
is_authentication | 公司是否被平台认证 | bool | 1：是，0：否
is_shown | 是否显示 | bool | 1：是，0：否
created_at | 创建时间 | string | 2016-09-26 23:33:31
updated_at | 最后更新时间 | string | 2016-09-26 23:33:31


** 响应实例：Response **
```json
{
  "data": [
    {
      "id": "1",
      "legal_person_id": "520",
      "legal_person_name": "John520",
      "name": "JC company520",
      "logo_img": "logopic",
      "city": "西安",
      "address": "西安海港区",
      "business": "高新科技520",
      "tag_name": "帅哥多,福利好,高薪,假期多",
      "tag_id": "1,3,5,9",
      "phone": "44023909093",
      "email": "123456@gmail.com",
      "official_website": "www.john520.com",
      "intro": "这是一家很多个性的公司",
      "others": "欢迎更多年轻人加入，我们需要你们",
      "industry": "互联网",
      "financing": "A轮",
      "corporation_type": "初创",
      "is_listing": 0,
      "is_authentication": 0,
      "is_shown": 1,
      "status": "10",
      "staff_num": "100",
      "created_at": "2016-10-31 10:30:00",
      "updated_at": "2016-10-31 10:30:00"
    },
    {
      "id": "2",
      "legal_person_id": "333",
      "legal_person_name": "John333",
      "name": "JC company333",
      "logo_img": "logopic",
      "city": "昆明",
      "address": "昆明清河区",
      "business": "高新科技333",
      "tag_name": "中蓝,藏青,栗色,黄绿,中海绿,亮鲑红,壳黄红,亮蓝,品红,橘色,兰紫,铬绿,青色,绯红",
      "tag_id": "0,2,3,5,6,9,10,12,13,15,16,17,18,19",
      "phone": "",
      "email": "",
      "official_website": "",
      "intro": "",
      "others": "",
      "industry": "互联网",
      "financing": "B轮",
      "corporation_type": "初创",
      "is_listing": 0,
      "is_authentication": 0,
      "is_shown": 1,
      "status": "20",
      "staff_num": "50",
      "created_at": "2016-10-31 10:30:00",
      "updated_at": "2016-10-31 10:30:00"
    },
    ...
  ],
  "meta": {
    "pagination": {
      "total": 10,
      "count": 10,
      "per_page": 15,
      "current_page": 1,
      "total_pages": 1,
      "links": []
    }
  }
}
```


### 获取某间企业/公司
`GET /corporations/{id}`

请求字段
字段 | 含义 | 是否必须 | 数据类型 | 备注
------------- | ---------------- | :-----------------: | ------------ | ------------------
id | 公司id | Y | int | 需要写在URL上，如 `/corporations/1` 获取id为1的公司

响应字段
字段 | 含义 | 数据类型 | 备注
--------------- | ---------------- | :-----------------: | ------------ | ------------------
id | 公司id | int |
legal_person_id | 法人id | string | 
legal_person_name | 法人名字 | string | 
name | 公司名字 | string | 
logo_img | logo的URL | string |
city | 公司所在城市 | string |
address | 公司详细地址 | string | 
business | 公司所经营的业务 | string |
industry | 公司所属行业 | string |
financing | 融资情况 | string | 如：种子轮，天使轮，A，B，C，D，E轮，不需要融资
status | 当前状态 | int | 10：审核中/待审核，20：正常/审核通过，30：禁止（从正常转为禁止），40：审核不通过
staff_num | 员工数量 | int |
corporation_type | 公司类型 | string | 上市企业，大型企业，中小型企业，初创
tag_name | 标签名 | string | 福利好，美女帅哥多，假期多...
tag_id | 标签id | int | 与标签名对应
phone | 公司联系电话 | string |
email | 公司邮箱 | string |
official_website | 公司官网 | stirng |
intro | 公司简介 | string |
others | 其他说明 | string |
is_listing | 是否上市 | bool | 1：是，0：否 
is_authentication | 公司是否被认证 | bool | 1：是，0：否
is_shown | 是否显示 | bool | 1：是，0：否
created_at | 创建时间 | string | 2016-09-26 23:33:31
updated_at | 最后更新时间 | string | 2016-09-26 23:33:31

** 响应示例：Response **
```json
{
  "data": {
    "id": "30",
    "legal_person_id": "782",
    "legal_person_name": "John782",
    "name": "JC company782",
    "logo_img": "www.jccompany782.com/image.jpg",
    "city": "南京",
    "address": "武汉高港区",
    "business": "高新科技782",
    "tag_name": "中蓝,亮柠檬绿,藏青,栗色,鹿皮鞋色,中海绿,香槟黄,暗红,亮鲑红,壳黄红,沙棕,亮蓝,品红,中兰紫,兰紫,铬绿,青色",
    "tag_id": "0,1,2,3,4,6,7,8,9,10,11,12,13,14,16,17,18",
    "phone": "14568745276",
    "email": "goptio@.com",
    "official_website": "www.jccompany782.com",
    "intro": "This is intro 782",
    "others": "This is others ",
    "industry": "互联网",
    "financing": "A轮",
    "corporation_type": "初创",
    "is_listing": 0,
    "is_authentication": 0,
    "is_shown": 1,
    "status": "40",
    "staff_num": "64",
    "created_at": "2016-10-31 11:35:35",
    "updated_at": "2016-10-31 11:35:35"
  }
}
```


### 创建企业/公司
`POST /corporations`

字段 | 含义 | 是否必须 | 数据类型 | 备注
------------- | ---------------- | :-----------------: | ------------ | ------------------
legal_person_id | 法人id | Y | string | 
legal_person_name | 法人名字 | Y | string | 
name | 公司名字 | Y | string | 
logo_img | logo的URL | Y | string | 
city | 公司所在城市 | Y | string |
address | 公司详细地址 | Y | string | 
business | 公司所经营的业务 | Y | string |
industry | 公司所属行业 | Y | string |
financing | 融资情况 | Y | string | 如：种子轮，天使轮，A，B，C，D，E轮，不需要融资
staff_num | 员工数量 | Y | int |
corporation_type | 公司类型 | Y | string | 上市企业，大型企业，中小型企业，初创
tag_name | 标签名 | N | string | 福利好，美女帅哥多，假期多...
tag_id | 标签id | N | int | 与标签名对应
phone | 公司联系电话 | N | string |
email | 公司邮箱 | N | string |
official_website | 公司官网 | N | string |
intro | 公司简介 | N | string |
others | 其他说明 | N | string |
is_listing | 是否上市 | Y | bool | 1：是，0：否

** 响应示例：Response **
创建成功返回HTTP状态码： `201`
响应体： 无
响应头： `Location: BASE_URL/corporations/{id}` 如： `Location: BASE_URL/corporations/1`


### 修改某间企业/公司
`PUT/PATCH /corporations/{id}`

请求字段
字段 | 含义 | 是否必须 | 数据类型 | 备注
------------- | ---------------- | :-----------------: | ------------ | ------------------
id | 公司id | Y | int | 需要写在URI上，如 `/corporations/1` 修改id为1的公司
legal_person_id | 法人id | Y | string | 
legal_person_name | 法人名字 | Y | string | 
name | 公司名字 | Y | string | 
logo_img | logo的URL | Y | string | 
city | 公司所在城市 | Y | string |
address | 公司详细地址 | Y | string | 
business | 公司所经营的业务 | Y | string |
industry | 公司所属行业 | Y | string |
financing | 融资情况 | Y | string | 如：种子轮，天使轮，A，B，C，D，E轮，不需要融资
staff_num | 员工数量 | Y | int |
corporation_type | 公司类型 | Y | string | 上市企业，大型企业，中小型企业，初创
tag_name | 标签名 | N | string | 福利好，美女帅哥多，假期多...
tag_id | 标签id | N | int | 与标签名对应
phone | 公司联系电话 | N | string |
email | 公司邮箱 | N | string |
official_website | 公司官网 | N | string |
intro | 公司简介 | N | string |
others | 其他说明 | N | string |
is_listing | 是否上市 | Y | bool | 1：是，0：否
is_shown | 是否显示 | N | bool | 1：是，0：否
is_authentication | N | bool |是否被平台认证 | 1：是，0：否。ps：只有平台管理者才有权限修改该字段。
status | 状态 | N | int | 10：创建后-待审核，15：修改后-待审核，20：正常/审核通过，30：禁止（从正常转为禁止），40：审核不通过。ps：只有平台管理者才有权限修改该字段。

** 响应示例：Response **
修改成功返回HTTP状态码： `204`
响应体： 无
响应头： 无


### 删除某间企业/公司
`DELETE /corporations/{id}`

请求字段
字段 | 含义 | 是否必须 | 数据类型 | 备注
------------- | ---------------- | :-----------------: | ------------ | ------------------
id | 行业id | Y | int | 需要写在URI上，如 `/corporations/1` 删除id为1的公司

删除成功返回HTTP状态码： `204`
响应体： 无
响应头： 无