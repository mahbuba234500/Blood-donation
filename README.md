# Blood Donation System

A web-based Blood Donation System built with Laravel and MySQL that helps connect blood donors with people in need. The system allows users to register, manage their profiles, mark themselves as donors, search for donors, create blood requests, and notify relevant nearby donors automatically.

## Features

- User registration and login
- User profile management and edit profile
- Users can mark themselves as blood donors
- Donors become automatically ineligible to donate again for 3 months after a donation
- Users can create blood donation requests
- Donors can respond to requests
- Donors can directly contact requesters through WhatsApp or phone call
- Users can search for available donors
- Automatic notification system for:
  - Relevant donors
  - Nearby donors when a blood request is created

## Tech Stack

- Backend: Laravel
- Database: MySQL
- Frontend: Blade / HTML / CSS / JavaScript
- Authentication: Laravel Auth
- Notification System: Laravel Notifications
- Communication: WhatsApp link and phone call integration

## How the System Works

### 1. User Registration and Login
Users can create an account and log in securely to access the system.

### 2. Profile Management
Each user can update their personal information, including contact details, blood group, address, and donor status.

### 3. Donor Availability
A user can mark themselves as a donor.  
Once a donor donates blood, the system automatically marks them as not eligible for the next 3 months.  
After 3 months, they become eligible again.

### 4. Blood Request
Any user can create a blood request by providing the required details such as:
- Blood group
- Location
- Contact information
- Emergency details

### 5. Donor Response
Eligible donors can view matching requests and respond to them.  
They can also directly contact the requester through:
- WhatsApp
- Phone call

### 6. Donor Search
Users can search for donors based on:
- Blood group
- Location
- Availability

### 7. Automatic Notifications
When a new blood request is created, the system automatically sends notifications to:
- Relevant donors by blood group
- Nearby donors based on location

## Installation

### Prerequisites

Make sure you have installed:

- PHP >= 8.x
- Composer
- MySQL
- Laravel
- Node.js and npm