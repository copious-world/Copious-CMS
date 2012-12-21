Copious-CMS
===========

Copious CMS is code in PHP and JavaScript for creating and managing content. Spec sheets in particular.



So, this code is from a few years ago, when I got into the CMS realm just figure a better interface for an e-commerce site.

STATE OF THIS CODE: 

I am uploading what I recall was working. 
I have to upload some SQL schema if anyone is ever going to find this useful. 

And, I am very interested in changing it since I have taken more interest in node.js and MongoDB as a backend, especially
for taxonomy management.

Also, documentation will be required if any one is to find their way around this.

PURPOSE OF THE CODE:

What I had working was a taxonomy editor. The texonomoy editor allowed for dragging and dropping words from a large 
dictionary onto trees. Once, the tree was defined, the user could drop fields onto the taxonomy, and edit the trees, etc.

The fields dropped onto the tree are definitions of form elements, by type. And, a library of form elements could be 
defined. So, a user would select form elements from a fairly complex library, hypothetically. At the last demonstration
of this software, there was a small form library. There was a plan for a community development of the form elements.

Once the tree had been annotated with form elements and stored, a member of the editing community could request a node
from the tree as a basis for creating a form. I had set up TineyEdit MCE, for a allowing the dropping of component onto 
a WYSIWYG editing page. The form creation allows for the specification of a family of objects. So, this abstract form would be stored.

Then, there would be a user from the product specification community who could use the abstract form 
in order to enter a product into the system. The fields of the form are supposed to be smart enough to 
allow ranges of physical values. So, the product specifier might enter operation ranges, or average values.
The product specifier might upload a picture of the object as well.  When the product specifier is done with his work,
he would save the completed, graphic display for the form.

As the new product is saved, it's HTML is saved. And, the form elements are analyzed so that physical constants could be 
saved for identifying the product.

When the form is completely entered into the system, the object described becomes available for search.

A member of the product hunting community will look for an element of a class of products. 
For that, he will be given an abstract search form derived from the WYSIWG abstract form for the family of objects.
He will be presented with ranges for physical constants in form elements.

When the user searched based on the form elements, the searcher will be presented with a narrow list of objects to choose from.

The CMS software should be ammenable to being used in purchasing situations.

The software should allow for fairly rapid searches based on numerical calculations and comparisons.


So, that is all for now. This software is not at the moment on the fron of anyones mind, including my own.
However, I can imagine revitalizing this effor with the help of others.




















