# Elite Evolution Real Estate — Luxury Property & Investment Portal

A high-performance luxury real estate portal engineered for the Dubai prime property market, compliant with **Dubai Land Department (DLD)** and **Real Estate Regulatory Agency (RERA)** regulatory frameworks.

[![Laravel](https://img.shields.io/badge/Laravel-8.x-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.x-blue.svg)](https://php.net)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)
[![Tests](https://img.shields.io/badge/Tests-17%20Passed-brightgreen.svg)]()

---

## 🌟 Key Highlights & Capabilities

### 1. DLD & RERA Regulatory Compliance
- **Trakheesi Advertising Permit Numbers:** Mandatory permit tracking and display across search cards, listings, and detail pages.
- **Madmoun QR Code Verification:** One-click modal verification for buyers and investors to validate property advertising permits directly with the Dubai Land Department.
- **Unique Property Reference Numbers:** Audit-ready cataloging (`EERE-V-101`, etc.) ensuring zero compliance risk (protecting against AED 50,000 regulatory penalties).

### 2. Licensed Broker & Agent Management
- **Administrative CRUD:** Full broker registry with RERA Broker Registration Number (BRN), agent photography, contact information, and multilingual profiles (English, Arabic, French, Russian, etc.).
- **Public Agent Profiles (`/agents/{slug}`):** Dedicated public broker portfolio pages showcasing active listings, transaction history, and direct WhatsApp / phone inquiry links.
- **Automatic Lead Routing:** Viewing and brochure requests automatically route to the assigned broker.

### 3. Property Finder-Grade Search & Discovery
- **Segmented Purpose-Aware Navigation:**
  - **Ready Properties (`/listing/ready`):** Move-in ready luxury villas, penthouses, and apartments.
  - **Off-Plan Investments (`/listing/off-plan`):** High-ROI off-plan launches with handover dates and developer links.
  - **Luxury Rentals (`/luxury-rentals`):** High-end leases with rental frequencies, cheque terms, and security deposit disclosures.
- **Location Hierarchy:** Multi-tier filtering across Communities, Sub-communities, and Towers.

### 4. Interactive Map Search (`/map-view`)
- **Split-Screen UX:** Side-by-side interactive map and property card view.
- **Custom Price Pins:** Clustered Leaflet.js pins displaying formatted property prices with zero external API key or billing dependency.
- **Interactive Previews:** Clicking pins reveals thumbnail cards with specs and direct detail links.

### 5. High-Touch Investor Features
- **UAE Mortgage & Payment Calculator:** Client-side financial estimator calculating monthly amortization based on purchase price, down payment, interest rate, and loan tenure.
- **Smart Similar Properties Engine:** Dynamically queries comparable listings within the same community and price bracket.
- **AI Concierge Assistant (`/api/concierge/chat`):** Natural language property search assistant capable of inventory lookups, answering client queries, and handing off warm leads directly to brokers via WhatsApp.

### 6. Executive Real Estate Dashboard
- **Admin CRM Overview (`/admin/dashboard`):** Real estate KPIs replacing legacy e-commerce widgets:
  - Active Properties Count
  - Licensed Brokers Count
  - Viewing Requests & Lead Inquiries
  - Recent Leads CRM Feed

---

## 🚀 Getting Started

### Prerequisites
- PHP >= 8.0
- Composer
- Node.js & NPM
- SQLite (or MySQL)

### Installation

1. **Clone the repository:**
   ```bash
   git clone https://github.com/jamersweb/elite-evolution.git
   cd elite-evolution
   ```

2. **Install PHP dependencies:**
   ```bash
   composer install
   ```

3. **Environment Setup:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database Migration & Seed:**
   ```bash
   touch database/database.sqlite
   php artisan migrate --seed
   ```

5. **Compile Frontend Assets:**
   ```bash
   npm install
   npm run dev
   ```

6. **Start the Development Server:**
   ```bash
   php artisan serve
   ```
   Open `http://127.0.0.1:8000` in your browser.

---

## 🧪 Automated Test Suite

Run the full automated test suite covering compliance, broker management, search routing, APIs, and lead capture:

```bash
php artisan test
```

All 17 tests verify:
- Homepage, listing, rental, map search, and policy pages
- DLD compliance fields (Trakheesi permit, Madmoun QR, Reference IDs)
- AI Concierge natural language responses
- Anti-spam brochure and viewing lead capture
- Admin broker CRUD and real estate executive KPI dashboard

---

## 🔒 Security & Privacy
- Honeypot anti-spam verification on all inquiry and viewing forms
- Spatie Role-Based Access Control (`admin`, `agent`, `user`)
- UAE PDPL & GDPR-compliant Cookies and Privacy Policy pages

---

## 📄 License
This project is proprietary software for **Elite Evolution Real Estate**.
