# InstantQuote-Remodel
Purpose:

Through development of a better pricing system for the instantquote, a pivot was made which changed the end goal of this program. This development has become a find your pan application that incorporates the quoting system along with it. We would like to make this module accessible on the home page of killarney metals to act like the face of the website. The goal of this is to allow the user to enter their basic needs for a pan then be directed to a selection of our stock pans that match their needs, along with the option to build their own custom pan.

Development:

For the development the original instantquote module was edited rather than making an entirely new module. For the most part nothing was changed in the module, besides adding new javascript, css and tpl files, the other changes and their files are listed below.

instantquote.php
-In hookDisplayHeader() a call the new CSS and JavaScript was added (lines 195 and 208)
-There is a new tab registered for CRU there is no functionality to it other than it appearing on the side bar. This will be needed in the future for the constant change of steel price. A new database table will most likely be needed or at the very least a column added to one of the existing tables that we can easily access (line 293)
