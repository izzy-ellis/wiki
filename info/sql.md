# SQL Commands
These are the commands that were run to set up the database for the Wiki

## pages table
```
CREATE TABLE `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'The ID value of the page',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'The time the page was edited/made',
  `abbreviation` text NOT NULL COMMENT 'The abbreviation of the page',
  `title` text NOT NULL COMMENT 'The title of the page',
  `description` text NOT NULL COMMENT 'A short description of the page',
  `category_id` int(11) NOT NULL COMMENT 'The category ID of the page',
  `sub_category_id` int(11) NOT NULL COMMENT 'The sub-category ID',
  `file_name` text NOT NULL COMMENT 'The name of the Markdown file',
  `keywords` text NOT NULL COMMENT 'A list of comma-separated keywords for search purposes',
  `times_visited` int(11) NOT NULL COMMENT 'Used to keep track of popular pages',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
```

## tag_page_relation table
Using a relation table here so I can do some cool data tracking on the tags

```
CREATE TABLE `wiki`.`tag_list` (`id` INT NOT NULL AUTO_INCREMENT COMMENT 'This is the index for the tag list' , `page_id` INT NOT NULL COMMENT 'The index for the relevant project' , `tag_id` INT NOT NULL COMMENT 'The index for the related tag' , PRIMARY KEY (`id`)) ENGINE = InnoDB;
```

## tags table
```
CREATE TABLE `wiki`.`tags` (`id` INT NOT NULL AUTO_INCREMENT COMMENT 'The ID of the tag' , `name` TEXT NOT NULL COMMENT 'The name of the tag' , `count` INT NOT NULL DEFAULT '1' COMMENT 'The number of times the tag is used' , `updated_at` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'The last time the tag was updated' ) ENGINE = InnoDB;
```

## category table
```
CREATE TABLE `wiki`.`category` (`id` INT NOT NULL AUTO_INCREMENT COMMENT 'The ID of the category' , `updated_at` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'The time the category was updated/made' , `name` TEXT NOT NULL COMMENT 'The name of the category' , `child_count` INT NOT NULL DEFAULT '1' COMMENT 'The number of sub-categorys' , PRIMARY KEY (`id`)) ENGINE = InnoDB;
```

We use the following command to add the references category, which will be a special category for reference pages. It should have an ID of 1
```
INSERT INTO category (name) VALUES ("references");
```

## sub-category table
```
CREATE TABLE `wiki`.`sub_category` (`id` INT NOT NULL AUTO_INCREMENT COMMENT 'The ID of the sub-category' , `updated_at` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'The time the sub-category was created/updated' , `name` TEXT NOT NULL COMMENT 'The name of the sub-category' , `parent_id` INT NOT NULL COMMENT 'The ID of the parent category' , `child_count` INT NOT NULL DEFAULT '1' COMMENT 'The number of files in the sub-category' , PRIMARY KEY (`id`)) ENGINE = InnoDB;
```

We use the following command to add the references sub-category, which will be a special sub-category for reference pages. It should have an ID of 1. We want to overwrite the child count because it will start with zero
```
INSERT INTO category (name, parent_id, child_count) VALUES ("references", 1, 0);
```