# Project Memory & Architecture Guide: ASPI-LARAVEL

## 1. Stack Overview
- **Framework**: Laravel 12.0 (PHP ^8.2)
- **Admin Template**: AdminLTE v3 (`jeroennoten/laravel-adminlte` ^3.15)
- **Front-end / Build**: Vite (`vite.config.js`), jQuery, DataTables, Select2 (bootstrap4 theme), Toastr, Smoke, Phosphor Icons, FilePond, Cropper.js, Summernote, Bootstrap Switch, Dropzone.
- **Base Helpers**: `app/helper.php` autoloaded via `composer.json`.

---

## 2. Core Architecture & Conventions

### Base Controller: `ZayaanController`
- Extends `App\Http\Controllers\Controller`.
- Uses `App\Traits\ResponseHelper`.
- Enforces `auth` middleware in constructor.

### Session & Multi-Tenancy Management: `ZayaanSessionManager`
- All multi-tenant session operations use `ZayaanSessionManager::get('user_info')`.
- Core Global Helper Functions (`app/helper.php`):
  - `getLoggedInUserDetails()`: Returns authenticated user payload.
  - `getSelectedBusiness()`: Returns active business array.
  - `getSelectedProfile()`: Returns active security profile array.
  - `getBusinessId()`: Returns ID of active business (`getSelectedBusiness()['id']`).
  - `getProfileId()`: Returns ID of active security profile (`getSelectedProfile()['id']`).
  - `allowCondition($key)`: Checks business level feature flags.
  - `productBehaviours($productType)`: Active `Xcodes` for product type.

### SPA Partial-Reload Mechanism
- Custom JS engine (`public/assets/js/kit-functions.js` & `kit-ui.js`).
- Direct URL Hit: Renders `index.blade.php` extending `layouts.app`.
- AJAX Navigation / Menu (`frommenu=Y`): Returns JSON with rendered Blade HTML snippet (`view('pages.XX.XX', ...)->render()`).
- Form Actions (Create / Update / Delete): Returns structured JSON via `ResponseHelper`:
  ```json
  {
    "status": "SUCCESS",
    "message": "Created successfully",
    "displayMessage": true,
    "reloadsections": [
      { "id": "main-form-container", "url": "/AD07?id=RESET", "postData": [] },
      { "id": "header-table-container", "url": "/AD07/header-table", "postData": [] }
    ]
  }
  ```
- Use `ReloadSection` and `AppendSection` helper objects in controllers:
  `$this->setReloadSections([ new ReloadSection('container-id', route('...')) ]);`

---

## 3. Screen & Controller Mapping Index

### System Administration (`SA` Series)
- `SA01Controller` -> Business Category (`business_categories`)
- `SA02Controller` -> Business Master (`businesses`)
- `SA03Controller` -> Business Admins (`user_businesses`)
- `SA04Controller` -> Page Management (`screens`, `screen_business_categories`)

### Application Admin & Security (`AD` Series)
- `AD02Controller` -> User Management (`users`)
- `AD03Controller` -> User Business Access
- `AD04Controller` -> Security Profile Management (`profiles`)
- `AD05Controller` -> Profile Details / Permission Assignment (`profiledts`, `menu_screens`)
- `AD06Controller` -> User Security Profile Assignment (`user_profiles`)
- `AD07Controller` -> Business Unit Management (`business_units`)
- `AD08Controller` -> Store / Warehouse Management (`stores`)
- `AD17Controller` -> Transaction Code Formats & Cadocs (`cadocs`)
- `AD18Controller` -> FilePond File Upload Handler
- `AD19Controller` -> TAX Category (`tax_categories`)
- `AD20Controller` -> TAX Rule (`tax_rules`)
- `AD21Controller` -> TAX Rule Components (`tax_rule_components`)

### Master Data (`MD` Series)
- `MD02Controller` -> Product Categories (`categories`)
- `MD03Controller` -> Product Attributes (`attributes`)
- `MD04Controller` -> Product Attribute Terms / Options (`terms`)
- `MD05Controller` -> Tags Management (`tags`)
- `MD06Controller` -> Product Labels (`product_labels`)
- `MD07Controller` -> Product Options & Option Details (`product_options`, `product_option_details`)
- `MD08Controller` -> Product Specification Groups (`product_specification_groups`)
- `MD09Controller` -> Product Specification Attributes & Options (`product_specification_attributes`, `product_specification_attribute_options`)
- `MD10Controller` -> Product Specification Tables & Table Groups (`product_specification_tables`)
- `MD11Controller` -> Brand Management (`brands`)
- `MD12Controller` -> Product Master & Items (`products`, `product_items`, `product_attributes`, `product_item_prices`, `product_costs`, `product_discounts`, `price_overrides`, `product_images`)
- `MD14Controller` -> Product Collections & Details (`product_collections`, `product_collection_details`)

### Financial Accounting & Entities (`FA` Series)
- `FA01Controller` -> Customer Management (`acsubs` where type = 'Customer')
- `FA02Controller` -> Supplier Management (`acsubs` where type = 'Supplier')

### Special / Utility Controllers
- `DashboardController` (`/DASH`): Dashboard overview
- `MainController` (`/`): Home & navigation selection
- `BusinessSelectionController` (`/business-selection`): Tenant selection
- `ProfileSelectionController` (`/profile-selection`): Security profile selection
- `SearchSuggestController` (`/search/...`): Datatables & Typeahead lookups
- `ForcePasswordChangeController` (`/set-password`): Force password change on first login

---

## 4. Key Developer Guidelines & Rules
1. **Always inherit `ZayaanController`** for authenticated admin features.
2. **Always scope business-bound data** using `where('business_id', getBusinessId())`.
3. **Return standardized AJAX responses** using `$this->setSuccessStatusAndMessage()`, `$this->setErrorStatusAndMessage()`, `$this->setReloadSections()`, and `$this->getResponse()`.
4. **Follow screen-code view naming**: `pages.[CODE].[CODE]`, `pages.[CODE].[CODE]-main-form`, `pages.[CODE].[CODE]-header-table`, `pages.[CODE].[CODE]-detail-table`.
5. **Preserve kit JS integration**: Standard form inputs use `kit-ui` bindings (`.select2`, `.select2bs4`, `.filepond`, `.colorpicker2`, `.typeahead`).
