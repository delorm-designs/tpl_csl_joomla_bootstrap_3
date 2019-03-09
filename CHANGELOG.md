##CSL Joomla! Mobile Responsive Bootstrap 3 Template

##Change Log
All notable changes to this project will be documented in this file.

##[3.0.0] - 2016-09-10

**Revised file structure:**

- Updated to T3 Blank v2.2.3
- Started with fresh changes
- Broke custom.less into smaller files
    - Created csl folder for csl specific less files


##[3.0.1] - 2016-09-18

- Fixed double pop-up on calender links
- Add ThemeMagic support for custom CSL LESS variables
- Changed CSL event module styles to work under core event module
- Removed absolute positioning coordinates on header for flexibility
- Adjusted Bootstrap header column definitions for better flexibility
- Adjusted header to allow for variables height adjusted to content
- Removed icon class from search markup to prevent icomoon icon showing

##[3.0.2] - 2017-02-22

- Fixed CSS width on RSForms! Pro field label to inherit bootstrap width
- Added CSS formatting to RSForms! Pro "2 Lines (XHMTL)" auto-generated layout
- Fixed ThemeMagic JCALPro month separator font style and font weight options
- Remove header-fixed-height variable and made the entire header have fluid
- Fixed JCALPro font style and weight options in ThemeMagic definitions
- Updated font style and font weights and added missing form header styles
- Fixed mobile sidebar width issues in the responsive design

Commits on Oct 01, 2016
- Removed unused definitions from CSL specific LESS and ThemeMagic files
- Use separate variables for h1-h6 font size to allow better themeing
- Made headings styles and RSForms legend header more consistent over-all 

Commits on Feb 09, 2017
- Changed column sizing, module spacing and other, miscellaneous changes
- Applied various button fixes, color variation fixes, and BS3 updates

Commits on Feb 11, 2017
- Modified header positions for better control of dynamic height header
- Made updates to off-canvas header bar styles to allow for themeing
- Made button primary themeable to the primary theme chosen for consistency
- Miscellaneous updates made throughout the CSL LESS files for consistency

Commits on Feb 16, 2017
- Add xhtml-inline form styles for greater default form coverage
- Make button on forms more consistent with buttons in the core
- Correct \<a> tag color over-ride in modules to match core links
- Correct font size and line height in modules to match core sizes
- Add JCalPro3 events module over-ride html for calendar link options 

Commits on Feb 22, 2017
- Correct off-canvas link color to match sidebar and core links
- Drop non-working off-canvas close button so make it less confusing
- Correct off-canvas button on tablet mode so that it actually works
- Bump version to 3.0.2 for preparation on new release cycle

##[3.0.3] - 2017-3-10
- Minor corrections to navbar and off-canvas colors
- Fixed issue with header height related it's modules

##[3.0.4] - 2017-3-10
- Minor updates to installer manifest
- Revert header bottom min height specification

##[3.0.5] - 2018-2-18
- Corrected HTML over-ride for JCAL Pro Events module for working event popups.

##[3.0.6] - 2018-2-18
- Changed JCalPro::canAddEvents() to JCalProHelperAccess::canAddEvents() in JCALPro over-rides.

##[3.0.7] - 2019-3-09
- Added en-GB.com_jcalpro.ini to the templates folder to be included as part of the template installation for JCAL Pro language fixes.
