# Japangcc
🚗 JapanGCC — Product &amp; Inventory Management System JapanGCC is a web application built with Laravel designed to manage vehicle and product inventories. Built around a 2-layer hierarchical architecture, it offers seamless registration, advanced filtering, and instant report generation for complex catalog management.

🔑 Key Features
📂 2-Layer Hierarchy Architecture
Category & Brand Classification: Structures data logically under parent Categories and sub-Brands (Category ➔ Brand ➔ Product).

Relational Data Protection: Built-in safeguards prevent the accidental deletion of parent Categories or Brands when active child products are linked.

📝 Product Registration & Specifications
Comprehensive Specs: Track full vehicle details including Chassis Number, Engine Number, Year, CC, Transmission, Drive (WD), Color, and ODO Meter.

Logistics & Grading: Manage administrative details such as Pickup Yards, Suppliers, Invoices, Scores, and Auction Grades.

Bulk Inventory Actions: Multi-select table interface allowing users to delete or update multiple items simultaneously.

📊 Reports & Data Exporting
PDF Report Generation: Export formatted product sheets and inventory summaries to downloadable PDF files.

CSV Data Export: Instant UTF-8 encoded CSV downloads formatted for Excel compatibility.

Print-Ready Views: Non-destructive CSS print stylesheets for quick physical printing without altering page performance.

🛠️ Tech Stack
Backend: Laravel (PHP)

Frontend: Blade, Bootstrap 5, FontAwesome, Vanilla JS

Database: MySQL

Export Utilities: DomPDF / Snappy PDF, CSV Blob Exporter
