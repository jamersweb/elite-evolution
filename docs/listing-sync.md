# Property catalogue import and sync

Admin > Properties lists imported records. **Sync Property Finder listings** starts an authenticated Atlas import and reports new, matched and withdrawn counts. **Property Finder details** opens the complete source listing, including fields without a dedicated website column, plus its resolved location. Only administrators can access those records or run the sync. Normal listing photos are served from the stored HTTPS media URLs. Signed or replaced URLs refresh on subsequent syncs.

## Configuration and deployment

Back up the database and public media, deploy the application, run php artisan migrate, and configure the private environment using .env.example. PROPERTY_FINDER_API_KEY and PROPERTY_FINDER_API_SECRET belong in the host environment or private .env. Run php artisan config:clear or rebuild cached configuration after setting variables. Never commit credentials.

LISTING_SYNC_ENABLED=true schedules an Atlas sync at 00:00 and 12:00 UTC. Enable Laravel's scheduler on the host by running php artisan schedule:run every minute in the project directory. Verify the schedule with php artisan schedule:list. The local Windows installation uses a Task Scheduler entry named Elite Evolution Laravel Scheduler. Production needs its own database, credentials and scheduler. Set LISTING_SYNC_ALERT_EMAIL and configure Laravel mail for email failure alerts.

Set LISTING_SYNC_WITHDRAW=true to hide previously imported Atlas listings missing from a complete active portfolio. Manual and CRM records are independent. Empty snapshots, duplicate IDs, conflicting references and incomplete pagination block withdrawal. Imports hold a cache lock and commit catalogue changes in one database transaction. An error rolls back that batch. Logs record results; scheduled attempts resume at the next interval. To undo a completed import, disable scheduling and restore the pre-import backup, accounting for any subsequent enquiries.

## Pilot and field mapping

Use php artisan listings:sync --property-finder --limit=10 to preview, or omit the limit for a complete preview. Preview rolls database changes back. Add --apply to write; add --withdraw only to a full snapshot. Stored source and ID prevent duplicates across runs. English and Arabic content, availability, property and permit details, agent profile IDs, floor plans, videos, image variants and all other fields returned in each listing are preserved in the administrator's record. The website maps supported fields including prices and rental periods, locations and coordinates, sizes, bedrooms, bathrooms, furnishing, amenities and media. Validate the intended recipient of website enquiries and the agency's media reuse rights for launch.

Use LISTING_SYNC_AGENT_MAP to map upstream profile IDs to existing local agent IDs, for example {"123":7}. LISTING_SYNC_LOCATION_MAP can override location fields by external location ID. Ordinarily lookup results are cached for 12 hours. If a location lookup returns 403 or 404, the listing keeps its location ID and any previously resolved details for that same ID. The next sync retries the lookup.

## Optional CRM export

Set CRM_LISTINGS_FILE or pass --file=/private/export.json to the general listings:sync command. The admin control and schedule always use Property Finder. For a CRM export use a complete JSON snapshot with an integer total and a results array matching the supplied Atlas listing format. Example:

    {"total":1,"results":[{"id":"crm-001","reference":"EE-001","title":{"en":"Waterfront villa"},"price":{"type":"sale","amounts":{"sale":5000000}},"type":"villa","location":{"community":"Jumeirah Islands"}}]}

The CRM owns portal publishing. New vendor formats and CRM enquiry delivery require the vendor's schema and consent workflow.
