/**
 * @license Copyright © 2013 Stuart Sillitoe <stuart@vericode.co.uk>
 * This work is mine, and yours. You can modify it as you wish.
 *
 * Stuart Sillitoe
 * stuartsillitoe.co.uk
 *
 */

CKEDITOR.plugins.add('strinsert',
{
	requires : ['richcombo'],
	init : function( editor )
	{
		//  array of strings to choose from that'll be inserted into the editor
		var strings = [];
		strings.push(['{email}', 'Email', 'Email']);
		strings.push(['{pass}', 'Password', 'Password']);
		
		strings.push(['{school}', 'College Name', 'College Name']);
				strings.push(['{logo}', 'College Logo', 'College Logo']);
				strings.push(['{coordinator_name}', 'Coordinator Name', 'Coordinator Name']);
				strings.push(['{Name}', 'Name', 'Name']);
				strings.push(['{group_name}', 'Group Name', 'Group Name']);
				strings.push(['{stud_complete_name}', 'Student Complete Name', 'Student Complete Name']);
				strings.push(['{t_complete_name}', 'Teacher Complete Name', 'Teacher Complete Name']);
				strings.push(['{status}', 'Status', 'Status']);
				strings.push(['{member_id}', 'Member ID', 'Member Id']);
				strings.push(['{school_id}', 'School Id', 'School ID']);
				strings.push(['{PRN}', 'Student PRN', 'Student PRN']);
				strings.push(['{std_phone}', 'Student Phone', 'Student Phone']);
				strings.push(['{t_id}', 'Teacher ID', 'Teacher ID']);
				strings.push(['{t_phone}', 'Teacher Phone', 'Teacher Phone']);
				strings.push(['{phone}', 'Phone', 'Phone']);
				strings.push(['{stud_first_name}', 'Student First Name', 'Student First Name']);
				strings.push(['{teach_first_name}', 'Teacher First Name', 'Teacher First Name']);
				strings.push(['{site}', 'Site Name', 'Site Name']);
				strings.push(['{user_type}', 'User Type', 'User Type']);
				strings.push(['{link}', 'Link', 'Link']);
				strings.push(['{vairal_link}', 'VairalLink', 'VairalLink']);
				strings.push(['{pass_admin}', 'School Admin Password', 'School Admin Password']);
				strings.push(['{pass_staff}', 'School Staff Password', 'School Staff Password']);

		// add the menu to the editor
		editor.ui.addRichCombo('strinsert',
		{
			label: 		'Insert Variable',
			title: 		'Insert Variable',
			voiceLabel: 'Insert Variable',
			className: 	'cke_format',
			multiSelect:false,
			panel:
			{
				css: [ editor.config.contentsCss, CKEDITOR.skin.getPath('editor') ],
				voiceLabel: editor.lang.panelVoiceLabel
			},

			init: function()
			{
				this.startGroup( "Insert Variable" );
				for (var i in strings)
				{
					this.add(strings[i][0], strings[i][1], strings[i][2]);
				}
			},

			onClick: function( value )
			{
				editor.focus();
				editor.fire( 'saveSnapshot' );
				editor.insertHtml(value);
				editor.fire( 'saveSnapshot' );
			}
		});
	}
});