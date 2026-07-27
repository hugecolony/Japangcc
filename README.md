# 🚗 JapanGCC — Product & Inventory Management System

**JapanGCC** is a robust Laravel application built for managing vehicle and product inventories with a structured **2-layer hierarchy architecture** (Categories & Brands). It provides a streamlined workflow for product registration, technical specification tracking, and comprehensive report generation.

---

## ✨ Key Features

### 📂 2-Layer Hierarchy Architecture
* **Category & Brand Structure:** Products are cleanly structured under parent Categories and child Brands (`Category` ➔ `Brand` ➔ `Product`).
* **Relational Data Integrity:** Prevents accidental deletion of categories or brands if active child products exist.

### 📝 Product Registration & Management
* **Comprehensive Specification Tracking:** Store detailed item specs including Chassis Number, Engine Number, Year, CC, Transmission, Drive (WD), Color, and ODO Meter.
* **Logistics & Grading:** Track Pickup Yards, Suppliers, Invoice Numbers, Scores, and Auction Grades.
* **Bulk Actions:** Multi-select functionality to manage or delete multiple products at once.

### 📊 Reporting & Exports
* **PDF Report Generation:** Export formatted product catalogues and detailed spec sheets to PDF.
* **CSV Data Export:** One-click data extraction into Excel-friendly CSV files with full UTF-8 encoding support.
* **Print-Ready Tables:** Non-destructive CSS print stylesheet for quick hardcopy generation directly from the web panel.

---

## 🛠️ Tech Stack

* **Framework:** Laravel 10 / 11
* **Database:** MySQL
* **Frontend:** Blade Templating, Bootstrap 5, FontAwesome 6
* **Scripts:** Vanilla JS (Fetch AJAX, CSV blob generation, Print handling)

---

## 🚀 Quick Setup

1. **Clone the repository:**
   ```bash
   git clone [https://github.com/your-username/japangcc.git](https://github.com/your-username/japangcc.git)
   cd japangcc
