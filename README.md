<picture>
  <source media="(prefers-color-scheme: dark)" srcset="https://www.larpwright.online/assets/ldf_logo_wh.png">
  <source media="(prefers-color-scheme: light)" srcset="https://www.larpwright.online/assets/ldf_logo_bl.png">
  <img align="right" alt="Larpwright Logo." src="https://www.larpwright.online/assets/ldf_logo_bl.png">
</picture>

# Larpwright Design Tools

A WordPress plugin for collaborating on larp design.
<br/><br/>

## Description
The Larpwright Design Tools plugin provides four custom post types and related custom taxonomies that may help with designing and planning a [larp](https://nordiclarp.org/wiki/Larp) (live-action role-play):
* Character
* Scene
* Location
* Prop

The focus is on collaboration allowing a team to jointly write characters and plots, comment on each other’s work, and track changes across revisions. The plugin depends on a couple of other plugins to provide its full potential, e.g., for linking connections between characters or adding logos or banners to custom taxonomies like in-game groups.

Please see the demo on [Larpwright Online](https://www.larpwright.online).

## Installation
1. Clone this GitHub repository locally or download a zip of the latest release.
2. In your WordPress admin dashboard, go to the 'Plugins > Add New' menu and choose 'Upload Plugin.' Choose the downloaded zip file.
3. Follow the onscreen instructions to install and activate the plugin.
4. Once activated, you will see an admin notice about required plugins (see screenshot). Follow the instructions below.
5. Lastly, follow the admin notice about permalinks (see screenshot) and adjust the settings for the required plugins.

**Screenshots**
![Screenshot of admin notices after activation.](https://www.larpwright.online/assets/activation.png)
![Screenshot of installation of required plugins.](https://www.larpwright.online/assets/required_plugins.png)

### Required Plugins Installation
Click the 'Begin installing plugins' link and install all necessary plugins. Click the checkmarks and choose 'Install' as a bulk action.

Go to 'Settings > Custom Related Posts.' Under 'General,' remove all other post types and add 'character' instead. Under 'Template,' choose 'Container > Normal' and 'Image > Floated Left' (leave image size as it is).

Go to 'RDV Category Image' and select 'character-type,' 'species,' 'profession,' and 'group.'

### Permalink Structure
We recommend changing the permalink structure to `/%category%/%postname%/` for optimal performance. You can change this under 'Settings > Permalinks.'

Even if you do not change the structure, go to this setting once and click 'Save Changes.' This will ensure that the new custom post types work.

## Uses
For each custom post type, the plugin provides a 'reusable block' template. For example, to create a new player character, choose 'Characters > Add New' and then select the 'PC' reusable block. At the top below 'Profile', you will see 'No categories' and 'No tags.' This is due to the respective taxonomies not being set yet. Make sure to convert the imported blocks to regular blocks (via the three ... menu). If you start editing before converting, the template will be changed not just the character you are working on. Now you can fill in the placeholders, choose relevant taxonomies, and add a featured image to your character (or location, or scene, or prop).

**Screenshot**
![Screenshot of how to use templates.](https://www.larpwright.online/assets/using_templates.png)

Once finished, publish the character like you would do with a regular post.

The plugin switches comments on by default for new characters, scenes, locations, and props. Thus, other team members can start commenting on the published material, make suggestions for edits, or explain edits they did themselves. 

The final 'product' can then be printed and used as handouts, for example (function under development).

### Characters
Characters come with five custom taxonomies for grouping them. Use the taxonomies that make sense for your larp.
* **Character Type**: The plugin installs three suggestions for character types as examples, player characters (PCs), non-player characters (NPCs), and guided player characters (GPCs).
* **Species**: Depending on your larp's setting, this can be humans, dwarves, or aliens.
* **Profession**: In a fantasy game, this may be classes like fighter and wizard. In a modern setting, professions can be real-world professions, such as baker or manager.
* **In-Game Group**: If you design a larp with different groups participants can belong to, use this taxonomy. 
* **Attitude**: This taxonomy can be used for things like 'alignments,' ethical outlooks, or motivations, depending on your setup.

Except for 'attitudes,' which function like tags, all other taxonomies function like categories (=hierarchical). This means you can setup sub-species, general and more specialized professions, or sub-groups within an organization. 

Using the functionality provided by the required plugin 'Custom Related Posts,' you can link characters (use the 'link' button on the top-right of the editing screen. This linking or connection does not make any statement about the kind of relationship the two characters may have. It adds the convenience of displaying who is somehow connected to whom and provides a quick way of switching to another character.

### Scenes
If your larp is episodic and works with predefined scenes, this is the place to set them up. Like the 'character' custom post type, scenes come with custom taxonomies helping you to structure your plot.
* **Episode**: Set up episodes or acts as larger frames for individual scenes.
* **Mood**: Designate a mood or feeling to scenes, such as 'rising tension' or 'feel good.'

### Locations
If your larp works with locations (instead or in addition to scenes), you can describe each location, its uses in particular scenes or for particular characters, and what items and props need to be put there. Custom taxonomies for locations include:
* **Size**: How you designate size is up to you. Making a statement about how many people fit a location has proven helpful.
* **Feature**: Features can include a common aspect of locations, such as access to the outside, stairs, or lighting equipment. This may help in choosing which location fits which scene.

### Props
Props range from costumes to furniture or (boffer) weapons. They come with the following taxonomies.
* **Prop Type**: You could order your props along the just mentioned categories of costume and furniture or what else makes sense for your larp. Prop types are hierarchical so that you can have an umbrella term, such as 'costume,' and sub-categories, such as 'pants' or 'gloves.'
* **Trait**: Traits can be designations of use, for example, if a prop is symbolical, just for decorations, or fulfills a particular function (is linked to some rules).

### Templates
For all custom post types, you find a template among the reusable blocks. These are just suggestions for how you can use the plugin. Feel free to create your own templates fitting your larp.

### Handouts
This is under development: Ideally, you will be able to just print the finished characters, scenes, locations, and props to be handed to players and game masters/assisting staff. This function will be added in a future release.

## Further Larp Settings
There are, of course, other aspects of a larp necessitating design, such as the overall world setting and game mechanics like rules or meta techniques. For this purpose, we suggest using the standard pages coming with WordPress. See the demo on [www.larpwright.online](https://www.larpwright.online) for suggestions.

In general, using WordPress this way helps in collaborating because any team member can access the texts from anywhere they are, for all items WordPress provides versioning, so that one can go back after a changes, and comments help in explaining changes etc.

If you want to ensure that only team members can access your website, you can use additional plugins, such as  [Restrict User Access](https://wordpress.org/plugins/restrict-user-access/). 

## Translation
The plugin is translation-ready and currently provided in English and German.
Feel free to contribute. The pot-file for translations is located in the languages folder.

## Copyright
Copyright &copy; 2023, [Björn-Ole Kamm](https://www.b-ok.de)

The Larpwright Design Tools plugin is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Larpwright Design Tools plugin is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with the Larpwright Design Tools. If not, see https://www.gnu.org/licenses/.

This plugin includes the [TGM-Plugin-Activation](https://github.com/TGMPA/TGM-Plugin-Activation) library for installing necessary additional plugins. Copyright &copy; 2011 Thomas Griffin (https://thomasgriffinmedia.com).

## Acknowledgements
The plugin development is part of the research project [Transcultural Learning through Simulated Co-Presence: How to Realize Other Cultures and Life-Worlds](https://kaken.nii.ac.jp/en/grant/KAKENHI-PROJECT-19KT0028/), funded by the [Japan Society for the Promotion of Science](https://www.jsps.go.jp/english/) (JSPS).
