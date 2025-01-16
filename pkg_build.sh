#!/bin/bash

# Variables
PLUGIN_NAME="BackupStatus"
VERSION="2025.10.15"
OUTPUT_DIR="/root"  # Replace with your desired output directory
SOURCE_DIR="/usr/local/emhttp/plugins/$PLUGIN_NAME"
PACKAGE_DIR="./$PLUGIN_NAME"
PLG_FILE="$OUTPUT_DIR/$PLUGIN_NAME.plg"
TXZ_FILE="$OUTPUT_DIR/$PLUGIN_NAME-$VERSION.txz"
GIT_URL="https://raw.githubusercontent.com/&author;/&name;-unraid/master/"  # Replace with your hosting URL

# Step 1: Prepare the Slackware Package Structure
echo "Preparing package structure..."
rm -rf "$PACKAGE_DIR"
mkdir -p "$PACKAGE_DIR/usr/local/emhttp/plugins/$PLUGIN_NAME"
cp -r "$SOURCE_DIR/"* "$PACKAGE_DIR/usr/local/emhttp/plugins/$PLUGIN_NAME"

# Step 2: Build the Slackware Package
echo "Building Slackware package..."
rm -f "$TXZ_FILE"
cd "$PACKAGE_DIR"
makepkg -l y -c y "$TXZ_FILE"
cd -

# Step 3: Generate MD5 Checksum
echo "Generating MD5 checksum..."
MD5SUM=$(md5sum "$TXZ_FILE" | awk '{print $1}')

# Step 4: Create the .plg File
echo "Creating .plg file..."
cat <<EOL > "$PLG_FILE"
<?xml version='1.0'?>
<!DOCTYPE PLUGIN [
<!ENTITY name "$PLUGIN_NAME">
<!ENTITY version "$VERSION">
<!ENTITY gitURL "$GIT_URL">
<!ENTITY pkgURL "&gitURL;/packages/$PLUGIN_NAME-$VERSION.txz">
<!ENTITY md5sum "$MD5SUM">
]>

<PLUGIN name="&name;" version="&version;">
  <FILE Name="/boot/config/plugins/&name;/&name;-&version;.txz" Min="6.9">
    <URL>&pkgURL;</URL>
    <MD5>&md5sum;</MD5>
  </FILE>
  <INSTALL>
    <COMMAND>installpkg /boot/config/plugins/&name;/&name;-&version;.txz</COMMAND>
  </INSTALL>
  <REMOVE>
    <COMMAND>removepkg $PLUGIN_NAME</COMMAND>
  </REMOVE>
</PLUGIN>
EOL

# Step 5: Output Results
echo "Slackware package built: $TXZ_FILE"
echo "Plugin file created: $PLG_FILE"
echo "Upload $TXZ_FILE to your server and ensure $PLG_FILE points to the correct URL."

