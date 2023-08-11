# Project Title
MiniCourse 3 สร้าง PHP Framework REST API ด้วย PHP OOP
MiniWorkshop สร้าง CRUD ระบบ เพิ่ม ลบ แก้ไข เรียกดูข้อมูล ทั้ง table และแบบ Modal 
v1.0.0

## Getting Started & Installing

- เริ่มต้นใช้งานฝั่ง Client
ให้เราเข้าไปตั้งค่า path api ที่ไฟล์
assets/js/main.js
ให้ตั้งค่า path ในตัวแปรนี้
axios.defaults.baseURL = 'ใส่ path api server ของเราลงไป'

- เริ่มต้นใช้งานฝั่ง Server
ให้เราเข้าไปตั้งค่าการเชื่อมต่อดาต้าเบสที่ไฟล์
service/api/.env
ให้เราเปลี่ยนค่า การเชื่อมต่อฐานข้อมูลในแบบของเรา

### Prerequisites
- ในส่วนของ Server โปรเจคตัวนี้ ควรรันอยู่บน PHP ตั้งแต่เวอร์ชั่น 7 เป็นต้นไป
- สำหรับฝั่ง Client สามารถใช้งาน Javascript ตั้งแต่ es5 เป็นต้นไป 

## Deployment
- ฝั่ง Server พัฒนาด้วย PHP7 + PHP OOP + Composer + PHP PDO
- ฐานข้อมูลเป็น MySQL
- ฝั่ง Client พัฒนาด้วย Vujes 2.6 รูปแบบการเขียนเป็นแบบ Option API (ไม่ได้ใช้ Vue Cli) 

## Authors & Contact
* **Yothin Sapsamran** - *Initial work* - [AppzStory](https://appzstory.dev/)
FanPage: https://www.facebook.com/WebAppzStory/
Youtube: https://www.youtube.com/appzstorystudio
Line: @appzstory

## License
โปรเจคนี้ ให้ไว้เป็นกรณีศึกษาของนักเรียนภายในคอร์ส AppzStory MiniCourse3 เท่านั้น
ห้ามนำแจกจ่าย หรือ ขายโดยเด็ดขาด
นักเรียนสามารถที่จะนำไปพัฒนาโปรเจคของตัวเองได้

