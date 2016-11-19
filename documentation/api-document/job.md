## Job Api 岗位接口

> Author zjien

### 获取全部岗位
`GET /jobs`

请求字段
字段 | 含义 | 是否必须 | 数据类型 | 备注
------------- | ---------------- | :-----------------: | ------------ | ------------------
name | 岗位名字 | N | string | 如：前端工程师
job_seq | 岗位编号 | N | string | 如：57e93fcb82243
comapny_id | 该岗位所属公司的id | N | int | 
comapny_name | 该岗位所属公司的名字 | N | string | 
type | 招聘类型 | N | int | 实习：10；校招：20；社招：30
salary | 薪水 | N | string | 如：5000
work_city | 工作城市 | N | string | 如：广州 
hr_id | 发布该岗位的 hr/员工 id | N | int |
is_shown | 是否显示 | N | int | 显示：1，不显示：0
status | 岗位状态 | N | int | 未开始：10；进行中：20；已结束：30
from_time | 开始时间 | N | string/timestamp | string形式为2016-09-20 10:20:30；timestamp为1475243580
to_time | 截止时间 | N | string/timestamp | string形式为2016-09-20 10:20:30；timestamp为1475243580
industry | 该岗位所属行业 | N | int | 行业id，可从行业列表中获取 
page | 当前页码 | N | int | 默认1
sorted_by | 根据哪个字段排序 | N | string | 如:sorted_by=created_at。默认根据created_at字段排序
order_by | 顺序 | N | string | 升序：ASC；降序：DESC
注意：不允许的字段会被忽略

响应字段
字段 | 含义 | 数据类型 | 备注
--------------- | ---------------- | :-----------------: | ------------ | ------------------
id | 岗位id | int |
job_seq | 岗位编号 | string |
name | 岗位名字 | string | 
company_id | 公司id | int | 
company_name | 公司名字 | string |
company_logo_url | 公司logo的url地址 | string |
type | 招聘类型 | string | 如：实习/校招/社招
salary | 薪水 | string | 如：5000； 200/日； 6000/月； 面议；
work_time | 工作时间 | string
work_city | 工作城市 | array | 如：["广州","深圳"]
hr_id | 发布该岗位的员工/hr id | int
intro | 岗位简介 | string
is_shown | 是否显示 | bool | 
status | 状态 | string | 
from_time | 开始时间 | string | 2016-09-25 21:53:00
from_time_timestamp | 开始时间时间戳 | int | 1474811580
to_time | 截止时间 | string | 2016-09-30 21:53:00
to_time_timestamp | 截止时间时间戳 | 1475243580
industry | 行业 | stirng |
module | 岗位详细介绍的其他模块 | string 
created_at | 创建时间 | string | 2016-09-26 23:33:31
updated_at | 最后更新时间 | string | 2016-09-26 23:33:31


** 响应实例：Response **
```json
{
  "data": [
    {
      "id": 23,
      "job_seq": "57e93ff15d561",
      "name": "前端工程师",
      "click": 0,
      "company_id": 1,
      "company_name": "腾讯",
      "company_logo_url": "www.baidu.com/image",
      "type": "实习",
      "work_time": "5天/周",
      "work_city": [
        "广州",
        "深圳"
      ],
      "hr_id": 1,
      "intro": "这是介绍，可选",
      "is_shown": false,
      "status": "已结束",
      "from_time": "2016-09-25 21:53:00",
      "to_time": "2016-09-30 21:53:00",
      "industry": "",
      "created_at": "2016-09-26 23:34:09",
      "updated_at": "2016-09-26 23:34:09",
      "module": 0,
      "salary": "面议",
      "from_time_timestamp": 1474811580,
      "to_time_timestamp": 1475243580
    },
    {
      "id": 22,
      "job_seq": "57e93fcb82243",
      "name": "UI设计师",
      "click": 0,
      "company_id": 1,
      "company_name": "腾讯",
      "company_logo_url": "www.baidu.com/image",
      "type": "实习",
      "work_time": "5天/周",
      "work_city": [
        "广州"
      ],
      "hr_id": 1,
      "intro": "这是介绍，可选",
      "is_shown": false,
      "status": "已结束",
      "from_time": "2016-09-25 21:53:00",
      "to_time": "2016-09-30 21:53:00",
      "industry": "",
      "created_at": "2016-09-26 23:33:31",
      "updated_at": "2016-09-26 23:33:31",
      "module": 0,
      "salary": "5000",
      "from_time_timestamp": 1474811580,
      "to_time_timestamp": 1475243580
    },
    ...
  ],
  "meta": {
    "pagination": {
      "total": 37,
      "count": 15,
      "per_page": 15,
      "current_page": 2,
      "total_pages": 3,
      "links": {
        "previous": "http://tecai.com/jobs?perPage=1&page=1",
        "next": "http://tecai.com/jobs?perPage=1&page=3"
      }
    }
  }
}
```





###添加岗位
`POST /`

字段 | 含义 | 是否必须 | 数据类型 | 备注
------------- | ---------------- | :-----------------: | ------------ | ------------------
title | 活动标题 | Y | string | \<=10
end_time | 截止报名时间 | Y | int | 时间戳
intro | 活动简介 | N | string | \<=1021
amount | 限制人数 | N | int | 为空时表示不限制人数
rock_time | 活动开始时间 | N | int | 时间戳
address | 活动地址 | N | string | 

**Response**
```json
{
  "code": 20000,
  "response": "添加成功"
}
```
