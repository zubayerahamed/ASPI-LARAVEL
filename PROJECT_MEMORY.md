# PROJECT MEMORY: ASPI-LARAVEL

> **Memory Created**: August 12, 2026  
> **Project Name**: ASPI (Laravel ERP / E-Commerce Master Platform)  
> **Purpose**: Instant reference guide to eliminate token overhead during development.

---

## 1. Project Overview & Tech Stack
- **Framework**: Laravel 12.0 (PHP ^8.2)
- **UI Framework**: AdminLTE 3 (`jeroennoten/laravel-adminlte` ^3.15)
- **Frontend Tools**: Vite (`vite.config.js`), jQuery, DataTables, Select2 (Bootstrap 4 theme), Toastr, Smoke UI, Phosphor Icons, FilePond, Cropper.js, Summernote, Bootstrap Switch, Dropzone.
- **Autoload Helpers**: `app/helper.php` (registered in `composer.json` under `autoload.files`).

---

## 2. Core Architectural Patterns

### A. Controller Inheritance & Response Pipeline
- All feature controllers extend `App\Http\Controllers\ZayaanController`.
- `ZayaanController` uses `App\Traits\ResponseHelper` and enforces `auth` middleware.
- Form submissions handle CRUD operations and return standardized JSON objects:
  ```php
  $this->setReloadSections([
      new ReloadSection('main-form-container', route('SA01', ['id' => 'RESET'])),
      new ReloadSection('header-table-container', route('SA01.header-table')),
  ]);
  $this->setSuccessStatusAndMessage("Saved successfully");
  return $this->getResponse();
  ```

### B. Front-End SPA Engine (`kit-functions.js` & `kit-ui.js`)
- **Direct Access**: URL opens `index.blade.php` which extends `layouts.app`.
- **AJAX Navigation**: Requests with `frommenu=Y` return JSON payload `{ "page": "<rendered html snippet>", "content_header_title": "..." }`.
- **Dynamic Container Reload**: Responses containing `reloadsections` dynamically reload DOM containers (`#main-form-container`, `#header-table-container`, `#detail-table-container`) via AJAX without a full page refresh.

### C. Multi-Tenancy & Session System (`ZayaanSessionManager`)
- Session management is centralized via `App\Services\ZayaanSessionManager`.
- Key Global Functions (`app/helper.php`):
  - `getLoggedInUserDetails()`: Active user array (`user_info`).
  - `getSelectedBusiness()`: Active tenant business array (`selected_business`).
  - `getSelectedProfile()`: Active RBAC profile (`selected_profile`).
  - `getBusinessId()`: Active tenant business ID.
  - `getProfileId()`: Active security profile ID.
  - `allowCondition($key)`: Evaluates business settings array flags.
  - `productBehaviours($type)`: Returns allowed product behaviours based on `Xcodes`.

---

## 3. Comprehensive Module Index

| Code | Title | Controller | Key Model(s) | Description |
|---|---|---|---|---|
| **SA01** | Business Category | `SA01Controller` | `BusinessCategory` | Category taxonomy for business tenants |
| **SA02** | Business | `SA02Controller` | `Business` | Master tenant company definitions |
| **SA03** | Business Admins | `SA03Controller` | `User`, `Business` | User-to-Business tenant assignments |
| **SA04** | Page Management | `SA04Controller` | `Screen`, `ScreenBusinessCategory` | Screen definitions & business category access |
| **AD02** | User Management | `AD02Controller` | `User` | Application user accounts |
| **AD03** | User Business Access | `AD03Controller` | `User`, `Business` | User business assignment |
| **AD04** | Security Profile | `AD04Controller` | `Profile` | RBAC Profile roles |
| **AD05** | Security Profile Details | `AD05Controller` | `Profiledt`, `MenuScreen` | Menu & screen permission matrix mapping |
| **AD06** | User Profile Assignment | `AD06Controller` | `UserProfile` | User-to-Profile security assignments |
| **AD07** | Business Unit | `AD07Controller` | `BusinessUnit` | Sub-business / division organizational units |
| **AD08** | Store / Warehouse | `AD08Controller` | `Store`, `BusinessUnit` | Physical stores & inventory locations |
| **AD17** | Cadoc / Doc Sequence | `AD17Controller` | `Cadoc` | Document auto-numbering & prefix/suffix sequence formats |
| **AD18** | File Upload Handler | `AD18Controller` | - | FilePond media upload & revert endpoint |
| **AD19** | TAX Category | `AD19Controller` | `TaxCategory` | Tax groupings & categories |
| **AD20** | TAX Rule | `AD20Controller` | `TaxRule` | Tax transaction rules & percentages |
| **AD21** | TAX Components | `AD21Controller` | `TaxRuleComponent` | Composite tax calculation components |
| **MD02** | Category Management | `MD02Controller` | `Category` | Hierarchical product categories tree |
| **MD03** | Product Attributes | `MD03Controller` | `Attribute` | Product variant attributes (e.g. Size, Color) |
| **MD04** | Attribute Options | `MD04Controller` | `Term` | Attribute option values / terms |
| **MD05** | Tags Management | `MD05Controller` | `Tag` | Searchable product tags |
| **MD06** | Product Labels | `MD06Controller` | `ProductLabel` | Product badges/labels (e.g. New, Sale) |
| **MD07** | Product Options | `MD07Controller` | `ProductOption`, `ProductOptionDetail` | Configurable product options |
| **MD08** | Specification Groups | `MD08Controller` | `ProductSpecificationGroup` | Tech specs groupings |
| **MD09** | Specification Attributes | `MD09Controller` | `ProductSpecificationAttribute`, `Option` | Spec attribute keys & allowed options |
| **MD10** | Specification Tables | `MD10Controller` | `ProductSpecificationTable`, `Group` | Spec table matrix templates |
| **MD11** | Brand Management | `MD11Controller` | `Brand` | Product brands & manufacturer info |
| **MD12** | Product Master | `MD12Controller` | `Product`, `ProductItem`, `ProductAttribute`, `ProductCost`, `ProductDiscount`, `PriceOverride`, `ProductImage` | Master PIM product catalog & variant engine |
| **MD14** | Product Collections | `MD14Controller` | `ProductCollection`, `Detail` | Curated product bundles & collections |
| **FA01** | Customer Management | `FA01Controller` | `Acsub` (type='Customer') | Customer profiles & accounts |
| **FA02** | Supplier Management | `FA02Controller` | `Acsub` (type='Supplier') | Vendor & supplier profiles |
| **DASH** | Dashboard | `DashboardController` | - | System metrics overview |
| **SYS** | Utility & Lookups | `SearchSuggestController` | `Xcodes`, `Address`, `Country`, `State`, `City` | Server-side Datatable search & Typeahead lookups |

---

## 4. Key Developer Rules & Best Practices
1. **Business Isolation**: Always filter database queries with `where('business_id', getBusinessId())`.
2. **Controller Pattern**: Extend `ZayaanController`, use `Validator::make()` for input validation, and use `ResponseHelper` methods (`setReloadSections`, `setSuccessStatusAndMessage`, `setErrorStatusAndMessage`) for form handling.
3. **View Structure**: Standardized page structure inside `resources/views/pages/[CODE]/`:
   - `[CODE].blade.php`: Parent page view
   - `[CODE]-main-form.blade.php`: CRUD form snippet container
   - `[CODE]-header-table.blade.php`: Header list table snippet container
   - `[CODE]-detail-table.blade.php`: Sub-item / detail list snippet container (if applicable)
4. **JS UI Integration**: Form controls leverage `kit-ui.js` initializers (`.select2`, `.select2bs4`, `.filepond`, `.colorpicker2`, `.typeahead`, `sweetAlertConfirm`).
