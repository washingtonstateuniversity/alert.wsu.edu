# WSU Alerts Child Theme

## Managing Alerts

Alerts are created as posts with 2 important details:

Site categories are used to classify the importance. The three main categories are "Announcements", "Emergency", and "Warning".

In the top right of the edit screen, "Alert Status" is available. For an alert to show as active, the drop down must be changed to **active**.

## Header

A common header is shown on all alert.wsu.edu pages and is populated with information on the latest active alert. This common header is split into two pieces.

### Overall alert status

The text at the top of the page changes depending on the status:

* Emergency: "There is an active emergency"
* Warning: "There is an active warning"
* None: "There are no alerts"

### Full Announcement

* If there are no active alerts, the area is colored green and the text shows "There are no warnings or emergencies".
* If there is an active **warning**, the area is colored yellow and the text of the warning is displayed.
* If there is an active **emergency**, the area is colored orange and the text of the warning is displayed.

## Front page

The front page (after the common header) displays the most recent 3 posts tagged as "Post to alert home page" (slug: `home`) in the first section. These can be categorized in any way.

The remaining sections on the page are customizable through the page builder interface.
