# SQL Commands
These are the commands that were run to set up the database for the Wiki

## pages table
```
CREATE TABLE `wiki_test`.`pages` (`id` INT NOT NULL AUTO_INCREMENT COMMENT 'The ID of the page' , `updated_at` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Last edited date' , `abbreviation` TEXT NOT NULL COMMENT 'The abbreviation of the page' , `title` TEXT NOT NULL COMMENT 'The title of the page' , `description` TEXT NOT NULL COMMENT 'A description of the page' , `category` TEXT NOT NULL COMMENT 'The major category of the page' , `sub_category` TEXT NOT NULL COMMENT 'The sub category of the page' , `file_name` TEXT NOT NULL COMMENT 'The file name of the page' , `keywords` INT NOT NULL COMMENT 'Extra keywords for the page' , PRIMARY KEY (`id`)) ENGINE = InnoDB;
```

## tag_list table
I believe I need two tables to link multiple tags to multiple projects (the old many-to-many relationship). If I'm wrong don't judge me, I did not pay attention in my degree

```
CREATE TABLE `wiki_test`.`tag_list` (`id` INT NOT NULL AUTO_INCREMENT COMMENT 'This is the index for the tag list' , `page_id` INT NOT NULL COMMENT 'The index for the relevant project' , `tag_id` INT NOT NULL COMMENT 'The index for the related tag' , PRIMARY KEY (`id`)) ENGINE = InnoDB;
```

## tags table
```
CREATE TABLE `wiki_test`.`tags` (`id` INT NOT NULL AUTO_INCREMENT COMMENT 'This is the ID of a particular tag' , `name` INT NOT NULL COMMENT 'This is the name of the tag' , PRIMARY KEY (`id`)) ENGINE = InnoDB;
```