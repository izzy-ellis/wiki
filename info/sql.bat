CREATE TABLE `wiki`.`pages` (`id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'The ID value of the page', `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'The time the page was edited/made', `abbreviation` text NOT NULL COMMENT 'The abbreviation of the page', `title` text NOT NULL COMMENT 'The title of the page', `description` text NOT NULL COMMENT 'A short description of the page', `category_id` int(11) NOT NULL COMMENT 'The category ID of the page', `sub_category_id` int(11) NOT NULL COMMENT 'The sub-category ID',`file_name` text NOT NULL COMMENT 'The name of the Markdown file', `keywords` text NOT NULL COMMENT 'A list of comma-separated keywords for search purposes', `times_visited` int(11) NOT NULL COMMENT 'Used to keep track of popular pages', PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
CREATE TABLE `wiki`.`tags` (`id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'The ID of the tag', `name` text NOT NULL COMMENT 'The name of the tag', `count` int(11) NOT NULL DEFAULT 0 COMMENT 'The number of times the tag is used', `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'The last time the tag was updated', PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
CREATE TABLE `wiki`.`tag_page_relation` (`id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'The ID of the relationship', `page_id` int(11) NOT NULL COMMENT 'The ID of the page', `tag_id` int(11) NOT NULL COMMENT 'The ID of the tag', PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
CREATE TABLE `wiki`.`category` (`id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'The ID of the category', `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'The time the category was updated/made',`name` text NOT NULL COMMENT 'The name of the category', `child_count` int(11) NOT NULL DEFAULT 0 COMMENT 'The number of sub-categorys', PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
INSERT INTO wiki.category (name) VALUES ("references");
CREATE TABLE `wiki`.`sub_category` (`id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'The ID of the sub-category', `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'The time the sub-category was created/updated', `name` text NOT NULL COMMENT 'The name of the sub-category', `parent_id` int(11) NOT NULL COMMENT 'The ID of the parent category', `child_count` int(11) NOT NULL DEFAULT 0 COMMENT 'The number of files in the sub-category', PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
INSERT INTO wiki.sub_category (name, parent_id, child_count) VALUES ("references", 1, 0);