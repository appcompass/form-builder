<?php include('header.php'); ?>
<div class="row">
    <div class="small-12 columns">
        <h1>Heading 1</h1>
        <h2>Heading 2</h2>
        <h3>Heading 3</h3>
        <h4>Heading 4</h4>
        <h5>Heading 5</h5>
        <h6>Heading 6</h6>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. <a href="">In tempor placerat</a> justo, vel mollis lorem gravida nec. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Nulla luctus ultrices tincidunt. Ut vitae lacus neque. Aenean eros ante, tristique tincidunt sollicitudin ac, sodales nec ante. Vestibulum orci ipsum, sagittis ut commodo in, sagittis vel nisl. In eget diam erat. In eget magna libero, ac semper eros. Maecenas bibendum elementum orci, eu imperdiet est porttitor sed. Donec vehicula ante et lorem malesuada scelerisque. Sed at tellus in ante vehicula euismod. Cras adipiscing, nulla in consequat hendrerit, arcu enim tempus purus, vel lacinia enim felis ac urna.</p>

        <p><i>Etiam cursus mollis leo</i>, <b>sit amet ultricies purus ultricies at</b>. Fusce laoreet lectus sit amet ligula eleifend at convallis odio egestas. Curabitur ac cursus diam. Integer non eros at enim condimentum pretium. Morbi semper nisi eu lectus bibendum semper aliquam enim molestie. Nunc pretium vestibulum quam, vitae interdum justo laoreet at. Nullam congue porta est eget malesuada. Morbi non massa nulla, eget aliquet massa. Suspendisse hendrerit nibh vitae neque pellentesque eget aliquam nulla iaculis. Cras iaculis dapibus odio, at placerat nisi tristique at. Quisque iaculis, nulla sed tristique dapibus, mi nunc mattis urna, eget volutpat purus dolor cursus urna. <a href="">Nunc ut est id</a> est imperdiet cursus ultrices a nisi.</p>

        <ul>
        	<li>Etiam cursus mollis leo, sit amet ultricies purus ultricies at.</li>
            <li>Fusce laoreet lectus sit amet ligula eleifend at convallis odio egestas.</li>
            <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>
        </ul>

        <ol>
        	<li>Etiam cursus mollis leo, sit amet ultricies purus ultricies at.</li>
            <li>Fusce laoreet lectus sit amet ligula eleifend at convallis odio egestas.</li>
            <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>
        </ol>
            
        <blockquote>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In tempor placerat justo, vel mollis lorem gravida nec. <cite>-John Doe</cite></blockquote>

        <form>
        	<label>Text Input</label>
            <input type="text">
            <label>Password</label>
            <input type="password">
            <label>Select</label>
            <select>
            	<option>Option One</option>
                <option>Option Two</option>
            </select>
            <label>Custom Select</label>
            <div class="select">
                <select>
                    <option>Option One</option>
                    <option>Option Two</option>
                </select>
                <span class="place"></span>
            </div>
            <label>Textarea</label>
            <textarea rows="5"></textarea>
            <label><input type="radio" name="radio">Radio</label>
            <div class="radio">
                <input type="radio" name="radio" id="custom-radio">
                <label for="custom-radio">Custom Radio</label>
            </div>
            <label><input type="checkbox">Checkbox</label>
            <div class="checkbox">
                <input type="checkbox" name="" id="custom-checkbox">
                <label for="custom-checkbox">Custom Checkbox</label>
            </div>
           	<input type="submit" value="Submit Input">
            <button type="button">Button</button>
        </form>
    </div>
</div>
<?php include('footer.php'); ?>	