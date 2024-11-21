# Wiki
My attempt at making a cheap and cheerful wiki

## To-do list
- ### Create Form
	- Input validation
	- Something is wrong with the sub categories, probably need to add some JS
- ### Misc
	- Finish index.php code
	- Add tag pages
	- Add reference pages

## Known issues
- When linking in Markdown, you need to include the root folder of the page (in this case /wiki/page.php). I do not know if this will apply on LAMP (I guess it depends on whether I have a root folder)
	- I've got rid of Markdown rendering for now, mainly because the code wouldn't work, but also because HTML will give better control
- The tag autocomplete is rusty as hell, throws lots of minor errors, none of them seem to be fatal though
- The database connection is definitely the most secure thing in the world
- The function page_creation.php/folder_exists() may not work on Linux, needs checking on Ubuntu Server
