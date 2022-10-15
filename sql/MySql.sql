CREATE TABLE `course` (
  `id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `price` int(11) NOT NULL,
  `duration` int(11) NOT NULL,
  `short_description` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `picture` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL,
  `program_items` varchar(255) NOT NULL,
  `date` varchar(50) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `teacher` (
  `id` int(11) NOT NULL,
  `name` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(60) NOT NULL,
  `email` varchar(60) NOT NULL,
  `password` varchar(60) NOT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `role` varchar(60) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE `course`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user.id` (`user_id`),
  ADD KEY `teacher_id` (`teacher_id`) USING BTREE;

ALTER TABLE `teacher`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `course`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `teacher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;
