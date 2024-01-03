<?php
// Define the path to the version file
$versionFile = 'version.txt';

// Read the current version number from the version file
$currentVersion = file_get_contents($versionFile);

// Prompt the user to enter the type of version they want to update
echo "Enter the type of version you want to update:\n";
echo "1 - Major\n";
echo "2 - Minor\n";
echo "3 - Patch\n";
$versionType = trim(fgets(STDIN));

// Check if the user entered "help" for the version type
if ($versionType == 'help') {
	echo "version_types:\n";
	echo "  1 - Major version: A major version number is usually incremented when there are significant changes to the software that may break compatibility with previous versions. For example, adding or removing major features or changing the architecture of the software. \n";
	echo "  2 - Minor version: A minor version number is incremented when new features are added or existing features are modified, but the changes are not significant enough to break compatibility with previous versions.\n";
	echo "  3 - Patch version: A patch version number is incremented when bugs or security issues are fixed, without adding new features or making significant changes to the software.\n";
	exit();
}
// Check if the version type is valid
if (!in_array($versionType, array('1', '2', '3'))) {
	die('Error: Invalid version type. Please enter either "1", "2" or "3".');
}

// Increment the appropriate version number based on the version type
list($major, $minor, $patch) = explode('.', $currentVersion);
if ($versionType == '1') {
	$major++;
	$minor = 0;
	$patch = 0;
} elseif ($versionType == '2') {
	$minor++;
	$patch = 0;
} elseif ($versionType == '3') {
	$patch++;
}

// Build the new version number
$newVersion = "$major.$minor.$patch";

// Check if the current version number is the same as the new version number
if (version_compare($currentVersion, $newVersion, '>=')) {
	die('Error: The current version number is not lower than the new version number.');
}

// Write the new version number to the version file
file_put_contents($versionFile, $newVersion);

// Print a message to confirm the new version number
echo "The version number has been updated to $newVersion.";
