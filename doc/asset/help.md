# راهنمای استفاده از وب‌سرویس اسکای‌روم

##  آشنایی با وب‌سرویس اسکای‌روم

###  معرفی
وب‌سرویس اسکای‌روم با هدف یک‍پارچه‌سازی و بکارگیری سرویس‌های اسکای‌روم در سایر سامانه‌ها و برنامه‌های نرم‌افزاری طراحی و پیاده‌سازی شده است. با بهره‌گیری از وب‌سرویس اسکای‌روم می توانید سرویس‌ها، اتاق‌های مجازی، کاربران و سایر امکانات فراهم شده را از درون سامانه یا اپلیکیشن خود و با فراخوانی دستورات وب‌سرویس (API) مدیریت نمایید.

### مشخصات فنی
وب‌سرویس اسکای‌روم بر پایه REST طراحی و پیاده‌سازی گردیده و در آن تلاش شده است تا ضمن الگوبرداری از استانداردهای رایج دنیا، سادگی در اولویت نخست باشد. از اینرو در وب‌سرویس اسکای‌روم تمامی درخواست(request)ها به شکل POST ارسال می گردند. فرمت داده‌های ارسالی (content-type) می‌تواند یکی از انواع JSON یا URL-Encoded باشد اما پاسخ همواره JSON خواهد بود. همچنین به منظور تفکیک خطاهای شبکه و سرور از خطاهای برنامه، تمامی پاسخ‌ها از سوی وب‌سرویس، چه موفق چه ناموفق، با کد وضعیت 200 برگردانده می شود (200 = HTTP Status Code).

### آدرس وب‌سرویس
ساختار آدرس(URL) وب‌سرویس بدین‌گونه است:
```
https://www.skyroom.online/skyroom/api/{your-api-key}
```  
که در آن `{your-api-key}` یک رشته به طول ۵۰ حرف و کلید اختصاصی شما برای استفاده از وب‌سرویس می‌باشد. به این ترتیب این کلید همواره جزء ثابتی از آدرس وب‌سرویس برای تمامی درخواست‌های ارسالی خواهد بود.

### ارسال درخواست
شکل کلی یک درخواست به صورت زیر است:
```http
POST https://www.skyroom.online/skyroom/api/skyroom-71-819540-0f178abb0c712c4cfd5ae13e4c54687a
{
  "action": "actionName",
  "params": {
    "param_1": "value1",
    "param_2": "value2",
    "param_3": "value3",
    ...
  }
}
```
در اینجا `action` تابعی است که قصد فراخوانی آن را داریم و `params` دربردارنده سایر پارامترهای تابع می‌باشد. توجه داشته باشید که نام تابع و پارامترهای ارسالی به کوچکی و بزرگی حروف حساسند.

### دریافت پاسخ
فرم کلی تمامی پاسخ‌های دریافتی از وب‌سرویس به صورت زیر است:
```json
{
  "ok": true,
  "result": "action-result"
}
```
مقدار `ok` می‌تواند true یا false باشد که نشان‌دهنده موفق یا ناموفق بودن فراخوانی تابع است. چنانچه عملیات موفق باشد، نتیجه درون `result` قرار می‌گیرد. این مقدار بسته به نوع درخواست می‌تواند یکی از انواع عدد`number`، رشته`string`، آرایه`[]` یا آبجکت`{}` باشد. در ادامه چند نمونه از اشکال مختلف پاسخ آمده است:
```json
{
  "ok": true,
  "result": 12
}
```
```json
{
  "ok": true,
  "result": "https://www.skyroom.online/ch/web-conference"
}
```
```json
{
  "ok": true,
  "result": [
    "item1",
    "item2",
    "item3"
  ]
}
```
```json
{
  "ok": true,
  "result": {
    "key1": 32,
    "key2": "value2",
    "key3": [
      "item1",
      "item2",
      "item3"
    ]
  }
}
```

### مدیریت خطاها
همانطور که پیشتر اشاره شد، تمامی پاسخ‌های دریافتی از سمت وب‌سرویس اعم از موفق یا ناموفق با کد وضعیت 200 ارسال می‌گردد. در نتیجه چنانچه مقدار این کد (با استفاده از خواندن HTTP Header) عددی غیر از 200 باشد نشان دهنده بروز خطای شبکه یا سرور بوده و لازم است تا به گونه‌ای مدیریت شود. اما در مورد خطاهای  برنامه‌ای، پاسخ همواره به شکل زیر خواهد بود:
```http
HTTP/1.1 200 OK
{
  "ok": false,
  "error_code": 14,
  "error_message": "درخواست شما با خطا روبرو شد."
}
```
بدین ترتیب چنانچه عملیات ناموفق باشد دو مقدار `error_code` و `error_message` برگردانده می‌شود که به ترتیب بیانگر کد خطا و توضیح خطا می‌باشند.

کد خطاهای عمومی به قرار زیر است:

|کد خطا|توضیح|
|:---:|---:|
|10|کلید وب‌سرویس نامعتبر است.|
|11|کلید وب‌سرویس نامعتبر است.|
|12|درخواست شما غیرمجاز است.|
|13|درخواست شما معتبر نیست.|
|14|درخواست شما با خطا روبرو شد.|
|15|داده‌ مورد نظر پیدا نشد.|
<br>

## امکانات مدیریتی
امکانات مدیریتی ارایه شده در وب‌سرویس اسکای‌روم شامل سه بخش مدیریت سرویس‌ها، مدیریت اتاق‌ها و مدیریت کاربران می شود.

### ۱. مدیریت سرویس‌ها
(در دست پیاده سازی..)

<!---
هدف از سرویس‌ها در اسکای‌روم دسته‌بندی کردن اتاق‌های مجازی و همچنین اعمال برخی محدودیت‌ها همچون تعداد کاربر همزمان، حجم نفرساعت مصرفی، فضای دیسک، میزان آپلود و یا تعیین بازه زمانی برای بهره‌برداری از سرویس می‌باشد. برای ساخت اتاق‌های مجازی، وجود حداقل یک سرویس الزامی است.

#### مشخصات سرویس

|ویژگی|نوع|مقدار|
|:---|:---|---:|
|id|number|شناسه سرویس|
|title|string|عنوان سرویس به طول حداکثر ۱۲۸ حرف|
|description|string|شرح سرویس به طول حداکثر ۵۱۲ حرف|
|type|number|نوع سرویس (0: عمومی - 1: وب‌کنفرانس - 2: آموزش 3: وبینار 4: پخش زنده)|
|status|number|وضعیت سرویس (0: غیرفعال - 1: فعال)|
|max_online_users|number|سقف تعداد کاربر آنلاین|
|max_upload_size|number|اندازه مجاز برای آپلود فایل|
|disk_quota|number|فضای دیسک|
|time_limit|number|محدودیت نفرساعت|
|time_usage|number|نفرساعت مصرف شده|
|time_total|number|مجموع نفرساعت مصرف شده|
|start_time|Unix time|زمان شروع سرویس|
|stop_time|Unix time|زمان پایان سرویس|
|create_time|Unix time|زمان ایجاد|
|update_time|Unix time|آخرین بروزرسانی|

#### توابع سرویس
|نام تابع|شرح|مقدار بازگشتی|نوع مقدار بازگشتی
|:---|---:|---:|
|`getServices`|دریافت لیست سرویس‌های موجود|لیست سرویس‌ها|[]
|`getService`|دریافت مشخصات یک سرویس‌|مشخصات سرویس|{}
|`createService`|ایجاد سرویس‌ جدید|شناسه سرویس ایجاد شده|number
|`updateService`|بروزرسانی سرویس‌|true یا false|bool
|`deleteService`|حذف سرویس‌|true یا false|bool

#### دریافت لیست سرویس‌های موجود
##### درخواست:
```json
{
  "action": "getServices"
}
```

##### پاسخ:
```json
[
  {
    "id": 1,
    "title": "سرویس وب کنفرانس",
    "status": 1
  },
  {
    "id": 2,
    "title": "سرویس آموزش آنلاین",
    "status": 0
  }
]
```

#### دریافت مشخصات یک سرویس‌
##### درخواست:
```json
{
  "action": "getService",
  "service_id": 1
}
```

##### پاسخ:
```json
{
  "id": 1,
  "title": "سرویس وب کنفرانس",
  "description": null,
  "type": 1,
  "status": 1,
  "start_time": null,
  "stop_time": null,
  "create_time": 1479021195,
  "update_time": 1501559112,
  "max_online_users": 8,
  "time_limit": 720000,
  "time_usage": 184059,
  "time_total": 2487566,
  "max_upload_size": 20971520,
  "disk_quota": 1048576000
}
```

#### ایجاد سرویس‌ جدید
##### درخواست:
```json
{
  "action": "createService",
  "title": "سرویس آزمایشی"
}
```

##### پاسخ:
```json
3
```

#### بروزرسانی سرویس‌
##### درخواست:
```json
{
  "action": "updateService",
  "id": 3,
  "max_online_users": 50
}
```

##### پاسخ:
```json
true
```

#### حذف سرویس‌
##### درخواست:
```json
{
  "action": "deleteService",
  "id": 3
}
```

##### پاسخ:
```json
true
```
--->

### ۲. مدیریت اتاق‌ها
با استفاده از اتاق‌های مجازی می‌توان رویدادهای مختلف را به صورت همزمان و کاملا مجزا از یکدیگر برگزار نمود. هر اتاق دارای یک نام واحد می‌باشد که آدرس(URL) اتاق نیز با همین نام ساخته می‌شود و در نتیجه بهتر است این نام به صورت لاتین وارد شود. می توان برای اتاق‌ها برخی محدودیت‌ها همچون سقف کاربر آنلاین، میزان نفرساعت مصرفی و جلوگیری از ورود کاربران پیش از ورود اپراتور را بکار برد.

#### مشخصات اتاق

|ویژگی|نوع|مقدار|
|:---|:---|---:|
|id|number|شناسه اتاق|
|name|string|نام اتاق به لاتین و به طول حداکثر ۱۲۸ حرف|
|title|string|عنوان اتاق به طول حداکثر ۱۲۸ حرف|
|description|string|شرح اتاق به طول حداکثر ۵۱۲ حرف|
|status|number|وضعیت اتاق|
|guest_login|bool|ورود به صورت میهمان|
|op_login_first|bool|ابتدا اپراتور وارد شود|
|max_users|number|سقف تعداد کاربر آنلاین|
|session_duration|number|محدودیت طول نشست|
|time_limit|number|محدودیت نفرساعت|
|time_usage|number|نفرساعت مصرف شده|
|time_total|number|مجموع نفرساعت مصرف شده|
|create_time|Unix time|زمان ایجاد|
|update_time|Unix time|آخرین بروزرسانی|

#### توابع اتاق
|نام تابع|شرح|مقدار بازگشتی|نوع مقدار بازگشتی
|:---|---:|---:|
|`getRooms`|دریافت لیست اتاق‌های موجود|لیست اتاق‌ها|[]
|`countRooms`|دریافت تعداد اتاق‌های موجود|تعداد اتاق‌ها|number
|`getRoom`|دریافت مشخصات یک اتاق|مشخصات اتاق|{}
|`getRoomUrl`|دریافت آدرس یک اتاق|آدرس اتاق|string
|`createRoom`|ایجاد اتاق جدید|شناسه اتاق ایجاد شده|number
|`updateRoom`|بروزرسانی اتاق|1|number
|`deleteRoom`|حذف اتاق|1|number
|`getRoomUsers`|دریافت لیست کاربران دارای دسترسی به اتاق|لیست کاربران|[]
|`addRoomUsers`|افزودن دسترسی کاربران به اتاق|تعداد کاربران افزوده شده|number
|`removeRoomUsers`|حذف دسترسی کاربران از اتاق|تعداد کاربران حذف شده|number
|`updateRoomUser`|تغییر دسترسی کاربر به اتاق|1|number

#### دریافت لیست اتاق‌های موجود
##### درخواست:
```json
{
  "action": "getRooms"
}
```

##### پاسخ:
```json
{
  "ok": true,
  "result": [
    {
      "id": 1,
      "name": "meeting",
      "title": "اتاق جلسات",
      "status": 1
    },
    {
      "id": 2,
      "name": "learning-php",
      "title": "کلاس آموزش PHP",
      "status": 0
    }
  ]
}
```

#### دریافت تعداد اتاق‌های موجود
##### درخواست:
```json
{
  "action": "countRooms"
}
```

##### پاسخ:
```json
{
  "ok": true,
  "result": 2
}
```


#### دریافت مشخصات یک اتاق
##### درخواست:
```json
{
  "action": "getRoom",
  "params": {
    "room_id": 1
  }
}
```

##### پاسخ:
```json
{
  "ok": true,
  "result": {
    "id": 1,
    "name": "meeting",
    "title": "اتاق جلسات",
    "description": null,
    "status": 1,
    "guest_login": false,
    "op_login_first": true,
    "max_users": 8,
    "session_duration": null,
    "time_limit": null,
    "time_usage": 184486,
    "time_total": 3144460,
    "create_time": 1479021434,
    "update_time": 1501559112
  }
}
```

#### دریافت آدرس یک اتاق
##### درخواست:
```json
{
  "action": "getRoomUrl",
  "params": {
    "room_id": 1
  }
}
```

##### پاسخ:
```json
{
  "ok": true,
  "result": "https://www.skyroom.online/ch/faramooz/meeting"
}
```

#### ایجاد اتاق جدید
##### درخواست:
```json
{
  "action": "createRoom",
  "params": {
    "name": "math-exercise",
    "title": "کلاس حل تمرین ریاضی",
    "guest_login": false,
    "op_login_first": true,
    "max_users": 10
  }
}
```

##### پاسخ:
```json
{
  "ok": true,
  "result": 3
}
```

#### بروزرسانی اتاق
##### درخواست:
```json
{
  "action": "updateRoom",
  "params": {
    "room_id": 3,
    "max_users": 20
  }
}
```

##### پاسخ:
```json
{
  "ok": true,
  "result": 1
}
```

#### حذف اتاق
##### درخواست:
```json
{
  "action": "deleteRoom",
  "params": {
    "room_id": 3
  }
}
```

##### پاسخ:
```json
{
    "ok": true,
    "result": 1
}
```

#### دریافت لیست کاربران دارای دسترسی به یک اتاق
##### درخواست:
```json
{
  "action": "getRoomUsers",
  "params": {
    "room_id": 2
  }
}
```

##### پاسخ:
```json
{
  "ok": true,
  "result": [
    {
      "user_id": 6344,
      "username": "operator",
      "nickname": "اپراتور",
      "access": 3
    },
    {
      "user_id": 6345,
      "username": "presenter",
      "nickname": "ارایه کننده",
      "access": 2
    },
    {
      "user_id": 6347,
      "username": "user-150",
      "nickname": "کاربر عادی",
      "access": 1
    }
  ]
}
```
انواع دسترسی‌ها به اتاق عبارت است از «کاربر عادی»، «ارایه کننده»، «اپراتور» و «مدیر». جدول انواع دسترسی در انتهای همین صفحه آمده است.

#### افزودن دسترسی کاربران به یک اتاق
##### درخواست:
```json
{
  "action": "addRoomUsers",
  "params": {
    "room_id": 1,
    "users": [
        { "user_id": 6344 },
        { "user_id": 6345, "access": 2 }
    ]
  }
}
```

##### پاسخ:
```json
{
  "ok": true,
  "result": 2
}
```

#### حذف دسترسی کاربران از یک اتاق
##### درخواست:
```json
{
  "action": "removeRoomUsers",
  "params": {
    "room_id": 1,
    "users": [ 6344, 6345 ]
  }
}
```

##### پاسخ:
```json
{
  "ok": true,
  "result": 2
}
```

#### تغییر دسترسی کاربر به یک اتاق
##### درخواست:
```json
{
  "action": "updateRoomUser",
  "params": {
    "room_id": 1,
    "user_id": 6344,
    "access": 3
  }
}
```

##### پاسخ:
```json
{
  "ok": true,
  "result": 1
}
```

### ۳. مدیریت کاربران
برای ورود به اتاق‌های مجازی و شرکت در رویدادها نیاز به ساخت حساب کاربری خواهد بود. برای ساخت یک حساب کاربری، وارد کردن نام کاربری، گذرواژه و نام نمایشی الزامی است. با هر حساب کاربری تنها یک بار می‌توان وارد اتاق شد. اگر بخواهیم چند نفر به صورت همزمان از یک حساب کاربری استفاده کنند در این صورت می‌بایست یک حساب کاربری از نوع عمومی ایجاد کنید. پس از ساخت حساب کاربری نیاز است تا دسترسی کاربر به اتاق یا اتاق‌های مربوطه ایجاد شود.

#### مشخصات کاربر

|ویژگی|نوع|مقدار|
|:---|:---|---:|
|id|number|شناسه کاربر|
|username|string|نام کاربری به لاتین و به طول حداکثر ۳۲ حرف|
|nickname|string|نام نمایشی به طول حداکثر ۱۲۸ حرف|
|password|string|گذرواژه به طول حداکثر ۱۲۸ حرف|
|email|string|آدرس ایمیل به طول حداکثر ۱۲۸ حرف|
|fname|string|نام به طول حداکثر ۱۲۸ حرف|
|lname|string|نام خانوادگی به طول حداکثر ۱۲۸ حرف|
|gender|number|جنسیت|
|status|number|وضعیت کاربر|
|is_public|bool|کاربر عمومی|
|time_limit|number|محدودیت زمانی (ساعت)|
|time_usage|number|زمان مصرف شده (ساعت)|
|time_total|number|مجموع زمان مصرف شده (ساعت)|
|expiry_date|Unix time|تاریخ انقضا|
|create_time|Unix time|زمان ایجاد|
|update_time|Unix time|آخرین بروزرسانی|

#### توابع کاربر
|نام تابع|شرح|مقدار بازگشتی|نوع مقدار بازگشتی
|:---|---:|---:|
|`getUsers`|دریافت لیست کاربران موجود|لیست کاربران|[]
|`countUsers`|دریافت تعداد کاربران موجود|تعداد کاربران|number
|`getUser`|دریافت مشخصات یک کاربر|مشخصات کاربر|{}
|`createUser`|ایجاد کاربر جدید|شناسه کاربر ایجاد شده|number
|`updateUser`|بروزرسانی کاربر|1|number
|`deleteUser`|حذف کاربر|1|number
|`getUserRooms`|دریافت لیست اتاق‌های کاربر|لیست اتاق‌ها|[]
|`addUserRooms`|افزودن به اتاق‌های کاربر|1|number
|`removeUserRooms`|حذف از اتاق‌های کاربر|1|number
|`getLoginUrl`|دریافت آدرس ورود مستقیم به اتاق بدون نیاز به لاگین|آدرس (URL)|string

#### دریافت لیست کاربران موجود
##### درخواست:
```json
{
  "action": "getUsers"
}
```

##### پاسخ:
```json
{
  "ok": true,
  "result": [
    {
      "id": 1,
      "username": "parham",
      "nickname": "پرهام",
      "status": 1
    },
    {
      "id": 2,
      "username": "sara",
      "nickname": "سارا",
      "status": 1
    }
  ]
}
```

#### دریافت مشخصات یک کاربر
##### درخواست:
```json
{
  "action": "getUser",
  "params": {
    "user_id": 1
  }
}
```

##### پاسخ:
```json
{
  "ok": true,
  "result": {
    "id": 1,
    "username": "parham",
    "nickname": "پرهام",
    "email": "example@gmail.com",
    "fname": "پرهام",
    "lname": "عابدینی",
    "gender": 1,
    "status": 1,
    "is_public": false,
    "time_limit": null,
    "time_usage": 426466,
    "time_total": 8464516,
    "expiry_date": null,
    "create_time": 1489021434,
    "update_time": 1489021434
  }
}
```

#### ایجاد کاربر جدید
##### درخواست:
```json
{
  "action": "createUser",
  "params": {
    "username": "test-user",
    "password": "12345",
    "nickname": "کاربر عمومی",
    "status": 1,
    "is_public": true
  }
}
```

##### پاسخ:
```json
{
  "ok": true,
  "result": 3
}
```

#### بروزرسانی کاربر
##### درخواست:
```json
{
  "action": "updateUser",
  "params": {
    "user_id": 3,
    "password": "tu2017!"
  }
}
```

##### پاسخ:
```json
{
  "ok": true,
  "result": 1
}
```

#### حذف کاربر
##### درخواست:
```json
{
  "action": "deleteUser",
  "params": {
    "user_id": 3
  }
}
```

##### پاسخ:
```json
{
  "ok": true,
  "result": 1
}
```

#### دریافت لیست اتاق‌های یک کاربر
##### درخواست:
```json
{
  "action": "getUserRooms",
  "params": {
    "user_id": 1
  }
}
```

##### پاسخ:
```json
{
  "ok": true,
  "result": [
    {
      "room_id": 1,
      "name": "meeting",
      "title": "اتاق جلسات",
      "access": 1
    },
    {
      "room_id": 2,
      "name": "learning-php",
      "title": "کلاس آموزش PHP",
      "access": 2
    }
  ]
}
```

#### افزودن به اتاق‌های یک کاربر
##### درخواست:
```json
{
  "action": "addUserRooms",
  "params": {
    "user_id": 2,
    "users": [
        { "room_id": 1 },
        { "room_id": 2, "access": 2 }
    ]
  }
}
```

##### پاسخ:
```json
{
  "ok": true,
  "result": 2
}
```

#### حذف از اتاق‌های یک کاربر
##### درخواست:
```json
{
  "action": "removeUserRooms",
  "params": {
    "user_id": 2,
    "rooms": [ 1, 2 ]
  }
}
```

##### پاسخ:
```json
{
  "ok": true,
  "result": 2
}
```

#### دریافت آدرس ورود مستقیم به اتاق بدون نیاز به لاگین
##### درخواست:
```json
{
  "action": "getLoginUrl",
  "params": {
    "room_id": 1,
    "user_id": 1,
    "ttl": 300
  }
}
```
`ttl` یا Time To Live مدت زمان اعتبار لینک به ثانیه می‌باشد که در مثال بالا 300 ثانیه یا 5 دقیقه می‌باشد. پس از این مدت، لینک تولید شده معتبر نیست و در صورت استفاده، کاربر با خطای عدم اعتبار لینک روبرو می‌شود.

##### پاسخ:
```json
{
  "ok": true,
  "result": "https://www.skyroom.online/ch/faramooz/meeting/t/eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJleHAiOjE1MDY2MDgxMzYsInVpZCI6NjM0N30.uFp056uU4JRKk_UxBy7sw0dkS7qQ80JL05N5_u62zUs"
}
```
<br>

## کدهای مفید

#### وضعیت اتاق:
|کد|شرح|
|:---|:---|
|0|غیرفعال|
|1|فعال|

#### وضعیت کاربر:
|کد|شرح|
|:---|:---|
|0|غیرفعال|
|1|فعال|

#### جنسیت کاربر:
|کد|شرح|
|:---|:---|
|0|نامعلوم|
|1|مرد|
|2|زن|

#### دسترسی به اتاق:
|کد|شرح|
|:---|:---|
|1|کاربر عادی|
|2|ارایه کننده|
|3|اپراتور|
|4|مدیر|