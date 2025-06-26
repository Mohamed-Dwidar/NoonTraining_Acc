# Noon-Training Accounting System

## Overview
The Noon-Training Accounting System is a web-based application developed using the Laravel framework in PHP. It aims to streamline accounting processes for Noon-Training by providing features such as income tracking, expense management, financial reporting, and more.


## Features
- **Branch Division:** The system will be divided into branches, each with its own login accounts.
- **User Authentication:** Login credentials will be linked to each branch, with login data consisting of email and password. New account registration will be facilitated by the main website administrator.
- **Student Registration:** Students can register with their personal details, including name, ID number, contact information, and more.
- **Course Management:** Course registration will include details such as course name, group number, start and end dates, exam fees, etc.
- **Account Management:** Detailed accounts will be maintained for each student, including course details, payment status, certificate issuance status, and more.
- **Unknown Transfers Section:** A section will be available to record transfers made to the center's account from non-students, which will later be linked to student accounts.
- **Search Functionality:** Users can search for specific students by name or ID number.
- **Payment System:** Payments will be recorded with dates and amounts specified.
- **Multi-course Registration:** Students can register for multiple courses.
- **Customizable Display:** Display options will be tailored according to courses.
- **Certificate Recipients Display:** Display of certificate recipients per course, with filtering options.
- **Latest Payment Updates:** Display of the latest updates in student payments.
- **Reports:** Various reports including unpaid students, students with installments, non-payment of exam fees, complete course fee payers, certificate recipients, non-certificate recipients, students by sector, course and student details with payment breakdowns, and a report on dropouts with outstanding dues, each type marked with a specific color.

## Installation
1. Clone the repository: `git clone https://github.com/your/repository.git`
2. Navigate to the project directory: `cd noon-training-accounting-system`
3. Install dependencies: `composer install`
4. Copy `.env.example` to `.env` and configure your environment variables such as database connection.
5. Generate application key: `php artisan key:generate`
6. Run migrations: `php artisan migrate`
7. (Optional) Seed the database with sample data: `php artisan db:seed`

## Usage
1. Start the Laravel development server: `php artisan serve`
2. Access the application in your web browser at `http://localhost:8000`

## Configuration
- Database configuration can be updated in the `.env` file.
- Additional configuration settings can be found in the `config` directory.
