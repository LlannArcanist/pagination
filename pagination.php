<?php
include 'config.php';

$max = 5;

$query = mysql_query("SELECT COUNT(*) AS total FROM news");
$total = mysql_result($query, 0, 'total');

$pages = (($total % $max) > 0) ? (int)($total / $max) + 1 : ($total / $max);

$page = (isset($_GET['page']) || is_numeric($_GET['page'])) ? 
abs(filter_var($_GET['page'], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH)) : 1;

$page = max(min($pages, $page), 1);
$start = ($page - 1) * $max;
$newquery = mysql_query("SELECT * FROM news ORDER BY id ASC LIMIT {$start}, {$max}");

while($row = mysql_fetch_assoc($newquery)) {
?>
  <h2 class="blog-post-title"><?php echo $row['Title']; ?></h2>
  <p class="blog-post-meta"><?php echo $row['Date']; ?> by <a href="#"><?php echo $row['Author']; ?></a></p>
  <p><?php echo $row['Content']; ?></p>
  <hr>&copy; Llann Arcanist</hr>
<?php } ?>
