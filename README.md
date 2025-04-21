# 🚗 EasePark Online

**EasePark Online** is a web-based parking management system designed to streamline and enhance the parking experience for both users and administrators. This collaborative group project combines web and hardware integration, and I contributed as one of the core programmers.

---

## 📌 Overview

EasePark Online offers an efficient, secure, and user-friendly solution to manage:

- Parking slots  
- User accounts  
- Administrative tasks  
- Real-time hardware integration  

---

## ✨ Features

### 👤 User Features

- 🔐 **Registration & Login**  
- 🚗 **Real-Time Parking Status**  
- ✅ **Email & Code Verification**  
- 🔁 **Secure Password Reset/Change**

### 🛠️ Admin Features

- 📊 **Admin Dashboard**  
- 📡 **RFID Account Management**  
- 📚 **Parking Activity Logs**  
- 🧑‍💼 **User Management (Block/Unblock)**  
- 📧 **Admin Email Update**

### 🔒 Security

- 🔐 **Secure Session Management**  
- 🛡️ **Input Validation (SQLi/XSS Prevention)**  
- 📮 **Verification Codes for Sensitive Actions**

---

## 🧰 Tech Stack

**Frontend**: HTML, CSS, JavaScript, SweetAlert2  
**Backend**: PHP  
**Database**: MySQL  
**Hardware**: ESP32, RFID, Ultrasonic Sensors  
**Email**: PHPMailer  
**Version Control**: Git  

---

## 🔌 Arduino Integration

### 🔧 Hardware Components

- ESP32 Microcontroller  
- RFID Reader  
- Sensors  
- Buzzer  
- Powerbank  

### 📡 Key Hardware Features

- **Real-Time Monitoring**: ESP32 receives sensor data, updates web app via HTTP  
- **RFID-Based Access**: Verifies card, opens barrier via relay  
- **Stable Communication**: Wi-Fi enabled, with reconnection logic and HTTP/MQTT protocols  

---

## 🔄 Web ↔ Hardware Integration

- ESP32 sends data ➝ Web app (via HTTP POST)  
- Web app processes ➝ Updates MySQL database  
- Real-time dashboard ➝ Reflects changes for both users & admins  

### 🛠️ Challenges Solved

- ✅ Wi-Fi Connectivity: Auto-reconnect logic  
- ✅ Sensor Accuracy: Sensor calibration  
- ✅ Data Sync: Timestamp-based conflict handling  

---

## 🗂️ Project Structure

/admin -> Admin panel & tools
/user -> User dashboard & features
/verification -> Email/code verification pages
/park -> Parking slot management
/shenanigans -> Experimental features
/css -> Stylesheets
/phpmailer -> Email functionality (PHPMailer)


---

## ⚙️ How It Works

1. 📝 **User Registration**: Email verification with secure code  
2. 🔐 **Login System**: User/Admin login with session protection  
3. 📈 **Real-Time Status**: Dashboard displays current slot availability  
4. 📑 **Logs**: Admins access activity logs with full details  
5. 🧑‍💼 **Admin Control**: Manage users, slots, logs, and settings  
6. 🛡️ **Security Layer**: Code verification, session handling, and input validation  

---

## 👨‍💻 My Contribution

As a core programmer, I handled:

- 🔗 Arduino ↔ Website connectivity  
- 🧮 Parking slot and car count logic (Admin & User view)  
- 📊 Admin Parking Logs functionality  
- 🤝 Hardware & software integration  
- 🧠 Logic design for efficient parking data management  

---

## 🚀 Running the Project

1. `git clone` the repository  
2. Set up a **MySQL** database and import the schema  
3. Edit `connection.php` with your DB credentials  
4. Host on **XAMPP/WAMP** or any web server  
5. Open in your browser and explore!

---

## 🙏 Acknowledgments

Thanks to my amazing team for the collaboration and support that brought EasePark Online to life. This project showcases how hardware and web technologies can combine for real-world solutions.

---

## 📝 License

This project is for **educational purposes** only and not intended for commercial deployment.
