# Wiki
My attempt at making a cheap and cheerful wiki

## To-do list
- Redesign edit form for handling the actual pages
	- Can we make the edit form work off of the create_form?
- Change around linking to work with abbreviations
- Add tags to database on submission
- Add input validation on the create form
- Add CSS
- Add search feature
- Change formatting for the display page

## Known issues
- When linking in Markdown, you need to include the root folder of the page (in this case /wiki/page.php). I do not know if this will apply on LAMP (I guess it depends on whether I have a root folder)
- The tag autocomplete is rusty as hell, throws lots of minor errors, none of them seem to be fatal though
- The database connection is definitely the most secure thing in the world
