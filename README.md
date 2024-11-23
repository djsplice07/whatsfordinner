# whatsfordinner
My family has a hard time deciding what to get for dinner at least 2-3 times a week.  Once we decide, it's about 9:30 PM and we eat the same thing we always eat.  There was another project I used to use, but it broke when PHP 7 was released and I thought with a little ChatGPT, I may be able to figure something out... so here it goes.

![Picker_Screenshot](https://github.com/user-attachments/assets/f578baa3-4202-41b3-bbb1-23a8e50d8a5d)


#User Guide
What’s For Dinner?
Search
1.	Select the price category on you budget for the meal (can be blank if no preference)
2.	Select the type of cuisine you want to narrow it down to  (can be blank if no preference)
3.	Type a ‘Keyword’ or ‘Keywords’ if you want a specific food item (ie. Tacos)
4.	Click Find Restaurant to list your destination
* All fields are optional, so if you just want it to spit out something, just click “Find Restaurant”
** The cuisine and price categories are dynamically populated by the database, so if you would like add a different “Price” or change the values, you can do that on the DB side.

![screenshot01](https://github.com/user-attachments/assets/3d0f427c-d16c-4b39-8b7f-cd750a6b67b6)
 
Results
Once you have clicked “Find Restaurant,” your results should appear on the same page under “Selected Restaurant”
1.	This is the restaurant that was chosen for you
2.	Click the “View Menu” button to show the food items the restaurant serves
3.	A Google Map should appear; you can click “Directions” to launch a new tab and find out how to get to the establishment
 
 ![screenshot02](https://github.com/user-attachments/assets/d76dc875-11f4-47bc-83cc-78d5598a9a43)
 
Admin
Add Restaurants
1.	On the top right of the screen, you should see an “Admin” link.  Click it to navigate to the login page

 ![screenshot03](https://github.com/user-attachments/assets/31b9977f-aa4c-416c-97c7-fb247f4706ce)

2.	Once logged in, you should see more items in the menu bar

 ![screenshot04](https://github.com/user-attachments/assets/00bf8a54-ddd4-45a0-9236-998866b449e4)

3.	You should automatically be taken to the “Add Restaurants” page.  If, not, or you want to get back to this page, click the “Add Restaurants” link 
4.	This page will allow you to add new restaurants to the database
5.	Select the price category the restaurant you intend on adding falls into
6.	Type the Restaurant Name (required)
7.	Paste the Google Map Link found by doing the following
a.	To find the link to enter, search the restaurant and locate the correct one on maps.google.com
 
 ![screenshot05](https://github.com/user-attachments/assets/8add17a9-9944-4a8c-bd4e-442ed7b2fd81)

b.	Right click the restaurant and select ”Share this location”

![screenshot06](https://github.com/user-attachments/assets/60e6874d-057b-4fba-913d-210d6681a41f)

c.	Click the “Embed a map” and click on the “COPY HTML” link

![screenshot07](https://github.com/user-attachments/assets/480813f2-a552-4a2e-8fd5-d2176ba0deae)

d.	Paste the link in the “Google Map Link” and remove everything except the actual URL (first part). The first part to delete is as follows:
i.	<iframe src="
e.	remove everything except the actual URL (last part). The last part to delete is as follows:
i.	" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
f.	I guess the easy way to say it, is only include the part that is between the quotes “””

 ![screenshot08](https://github.com/user-attachments/assets/2335658b-d311-4d80-9a90-4c6995da2571)

8.	If you can find a link to the restaurants, paste that URL in the “Menu Link” Field
 
 ![screenshot09](https://github.com/user-attachments/assets/8d9a26c7-2513-488c-8325-06e6f3e27476)

9.	Type the food type/cuisine type in the “Food Type” field.  Try and keep these consistent (ie. Don’t use Mexican and Mexico)
 
 ![screenshot10](https://github.com/user-attachments/assets/c0deefb8-8c53-40a3-8151-d789e9adaf3d)

10.	Type the Keyword for future searches.  Make sure the entries are comma separated.  Also try and keep these consistent (ie. taco vs. tacos vs Taco or Tacos)(Capitalization matters)
 
 ![screenshot11](https://github.com/user-attachments/assets/5b46d79b-1b7f-482d-ac2b-2877d14a045f)

Manage Restaurats
1.	On the Manage Restaurants page, you should see all the restaurants that are entered in the database
2.	Here are the different columns as of v.1.0.0
a.	Name – Name of establishment
b.	Menu Link – A link to the menu for the establishment
c.	Cost Category – The price category
d.	Food Type – The cuisine type (ie. Chinese, Mexican, etc)
e.	Subcategory – Keywords that you can search for that can be anything (ie. cheeseburger, dinner, sit down, restaurant, vegan, etc)
f.	Actions – Here you have the options of
i.	Edit – Edit this entry for the establishment (this will take you to the “Edit Restaurants” page where it will show all the values previously entered and you can edit the entry for this specific establishment
ii.	Delete – delete the entry
Manage Users
1.	In this page you can add, edit passwords and delete the users of the application
 
 ![screenshot12](https://github.com/user-attachments/assets/85842a4d-f618-4424-b03f-a57a550e897a)

2.	Type a new user in the “Username” field
3.	Type a password for the new user in the “Password” field
4.	In the section below (Existing Users), it should list the current users of the system (there should always be at least one obviously)
5.	Click the “Delete” button to delete the listed user
6.	To change the user’s password, type the desired password in the “New Password” field and click the “Update Password” button
