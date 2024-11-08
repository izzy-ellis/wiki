# SQL Commands
These are the commands that were run to set up the database for the Wiki

## pages table
```
CREATE TABLE `wiki_test`.`pages` (`id` INT NOT NULL AUTO_INCREMENT COMMENT 'The ID value of the page' , `updated_at` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL COMMENT 'The time the page was edited/made' , `abbreviation` TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'The abbreviation of the page' , `title` TEXT NOT NULL COMMENT 'The title of the page' , `description` TEXT NOT NULL COMMENT 'A short description of the page' , `category_id` INT NOT NULL COMMENT 'The category ID of the page' , `sub_category_id` INT NOT NULL COMMENT 'The sub-category ID' , `file_name` TEXT NOT NULL COMMENT 'The name of the Markdown file' , `keywords` TEXT NOT NULL COMMENT 'A list of comma-separated keywords for search purposes' , `times_visited` INT NOT NULL COMMENT 'Used to keep track of popular pages' , PRIMARY KEY (`id`)) ENGINE = InnoDB;
```

## tag_page_relation table
Using a relation table here so I can do some cool data tracking on the tags

```
CREATE TABLE `wiki_test`.`tag_list` (`id` INT NOT NULL AUTO_INCREMENT COMMENT 'This is the index for the tag list' , `page_id` INT NOT NULL COMMENT 'The index for the relevant project' , `tag_id` INT NOT NULL COMMENT 'The index for the related tag' , PRIMARY KEY (`id`)) ENGINE = InnoDB;
```

## tags table
```
CREATE TABLE `wiki_test`.`tags` (`id` INT NOT NULL AUTO_INCREMENT COMMENT 'The ID of the tag' , `name` TEXT NOT NULL COMMENT 'The name of the tag' , `count` INT NOT NULL DEFAULT '0' COMMENT 'The number of times the tag is used' , `updated_at` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'The last time the tag was updated' ) ENGINE = InnoDB;
```

## category table
```
CREATE TABLE `wiki_test`.`category` (`id` INT NOT NULL AUTO_INCREMENT COMMENT 'The ID of the category' , `updated_at` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'The time the category was updated/made' , `name` TEXT NOT NULL COMMENT 'The name of the category' , `child_count` INT NOT NULL DEFAULT '0' COMMENT 'The number of sub-categorys' , PRIMARY KEY (`id`)) ENGINE = InnoDB;
```

## sub-category table
```
CREATE TABLE `wiki_test`.`sub_category` (`id` INT NOT NULL AUTO_INCREMENT COMMENT 'The ID of the sub-category' , `updated_at` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'The time the sub-category was created/updated' , `name` TEXT NOT NULL COMMENT 'The name of the sub-category' , `parent_id` INT NOT NULL COMMENT 'The ID of the parent category' , `child_count` INT NOT NULL DEFAULT '0' COMMENT 'The number of files in the sub-category' , PRIMARY KEY (`id`)) ENGINE = InnoDB;
```