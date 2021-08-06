# InstantQuote-Remodel

Purpose:

Through development of a better pricing system for the instantquote, a pivot was made changing the needs of this module. This development has become a find your pan application that incorporates the quoting system along with it. We would like to make this module accessible on the home page of killarney metals in the second or third block position to help route customers to their desired pan in a new way. The goal of this is to allow the user to enter their basic needs for a pan then be directed to a selection of our stock pans that match their needs, along with the option to build their own custom pan.

Development:

For the development the original instantquote module was edited rather than making an entirely new module. For the most part nothing was changed in the module, besides adding new javascript, css and tpl files, the other changes and their files are listed below.

instantquote.php
-	In hookDisplayHeader() a call the new CSS and JavaScript was added (lines 195 and 208)
-	There is a new tab registered for CRU there is no functionality to it other than it appearing on the side bar. This will be needed in the future for the constant change of steel price. A new database table will most likely be needed or at the very least a column added to one of the existing tables that we can easily access (line 293)

instaquote.tpl
-	Changed the included tpl file from single_shape.tpl to the new template findAPan.tpl (line 17). This was done for  the instantquote.tpl file within the module as well as the one in the killarney metals themes folder (srp-web\themes\killarneymetals\modules\instantquote\views\templates\front)

priceEngine.php
-	changed the smarty output content from single_shape.tpl to the new template file findAPan.tpl (line 96)

CSS and JavaScript:
-	The original CSS file (instantquote.css) is still in the module, however it has been commented out to keep from interfering with the new css that has been added.
-	draw.js and findAPan.css were added into the module for new design and added functionality


New JavaScript Functionality:

The major addition to this module has been within the draw.js file. All newly developed functionality is included in there and ranges from handling changes in tabs, redirecting to the final page, after completing the form, and the custom quoting. Below is a list of the key functions used. The pricing functionality is currently within this file but will be moved into the KmPanCostProcessor.php file soon to retain as much of the original pricing functionality as possible


-	draw(width, length, height, gauge, material): accepts values entered by the user and uses them to draw a basic blueprint for the pan with all schematics included. (line 180)

-	drawHole(d1, d2, d3, d4, d5, d6, d7): When a user selects to add a hole on their pan this function becomes active. It accepts a large range of values that have been altered from the user's input in order to correctly add the hole location to scale on their pan in the correct areas. (line 336)

-	download(): this was a function added to our desktop application which allows the blueprint to be downloaded and saved locally (line 456)

-	sheetCost(length, width, height, gauge, material, quantity): With the new pricing structure, pans are quoted based on the sheet size needed. This function accepts user inputs, chooses the appropriate sheet size, and calculates that cost. (line 504)

-	manufacturingCost(quantity, length, height): Calculates the size of the pan and quantity desired to calculate the manufacturing cost to make the pan. (line 690)

-	finalCost(): this is where all pricing functions are called to determine the final cost, draw the blueprint, and display all final information to the user. It is also currently being used to handle user errors, but this may be changed. (line 750)
