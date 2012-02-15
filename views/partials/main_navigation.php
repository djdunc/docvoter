<!-- MAIN NAVIGATION WITH ICON CLASSES -->
<div id="main-navigation">
	<div class="nav-wrap"> 
			<!-- The class "hide-on-mobile" will hide this navigation on a small mobile device. -->
			<ul class="hide-on-mobile">
				<li><a href="index.php"<?php if($page == 'dash'){ echo(" class=\"active\"");} ?>>Dashboard</a></li>
				<li><a href="index.php?do=decks"<?php if($page == 'decks'){ echo(" class=\"active\"");} ?>>Decks</a></li>
				<li><a href="index.php?do=events"<?php if($page == 'events'){ echo(" class=\"active\"");} ?>>Events</a></li>
				<li><a href="index.php?do=issues"<?php if($page == 'issues'){ echo(" class=\"active\"");} ?>>Issues</a></li>
			</ul>
			<!-- The class "show-on-mobile" will show only this navigation on a small mobile device. It's a dropdown select box that loads the page upon select. Dependant on JS within "custom.js" -->
			<div class="show-on-mobile">
					<select name="navigation" class="mobile-navigation">
						<option value="index.php">Home</option>
						<option value="grid.php">Create</option>
						<option value="page.php">Explore</option>
						<option value="stats.php">Admin</option>
					</select>
			</div>
	</div>
		<!-- END NAV WRAP -->
	</div>
	<!-- END MAIN NAVIGATION -->