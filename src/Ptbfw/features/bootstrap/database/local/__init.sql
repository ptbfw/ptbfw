SELECT 1;
/*

Place your sql code here :)

TRUNCATE TABLE `test`;

INSERT INTO `test` (
`id` ,
`text`
)
VALUES (
NULL , 'test1'
);

*/


DROP TABLE IF EXISTS `test`;
CREATE TABLE IF NOT EXISTS `test` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;