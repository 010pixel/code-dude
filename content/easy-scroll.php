<script type="text/javascript" src="<?php echo REL_DIR_URL . $this->data->library_dir;?>syntex-highlighter/scripts/shCore.js"></script>
<script type="text/javascript" src="<?php echo REL_DIR_URL . $this->data->library_dir;?>syntex-highlighter/scripts/shBrushJScript.js"></script>
<script type="text/javascript" src="<?php echo REL_DIR_URL . $this->data->library_dir;?>syntex-highlighter/scripts/shBrushPhp.js"></script>
<link type="text/css" rel="stylesheet" href="<?php echo REL_DIR_URL . $this->data->library_dir;?>syntex-highlighter/styles/shCore.css"/>
<link type="text/css" rel="stylesheet" href="<?php echo REL_DIR_URL . $this->data->library_dir;?>syntex-highlighter/styles/shThemeDefault.css"/>
<script type="text/javascript">
    SyntaxHighlighter.config.clipboardSwf = '<?php echo REL_DIR_URL . $this->data->library_dir;?>syntex-highlighter/scripts/clipboard.swf';
    SyntaxHighlighter.all();
</script>

<style>
	.table-container {background:#FFF; padding:10px; margin:0px 0 25px; box-shadow:0px 0px 5px #ccc;}
</style>

<div class="table-container">
    <h3>Parameters</h3>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th width="250">Setting</th>
                <th>Description</th>
                <th width="200">Default</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><code>elementContainer</code></td>
                <td>
                	The element in which scroll content exists. It can be full window or any container.<br />
                    e.g. #scroller-container
                </td>
                <td><code>window</code></td>
            </tr>
            <tr>
                <td><code>scrollElement</code></td>
                <td>The element containing content to be scrolled.</td>
                <td><code>#scroller</code></td>
            </tr>
            <tr>
                <td><div class="label label-info">(optional)</div> <code>trackerElement</code></td>
                <td>The element in which it will show some statistics to check the scroller functioning.</td>
                <td></td>
            </tr>
            <tr>
                <td><code>delta</code></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td><code>myMarginTop</code></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td><code>bottomSafeDistance</code></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td><code>_easingAmount</code></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td><code>_easingDelay</code></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td><code>_easingAmountDecreaseRatio</code></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td><code>_easingDelayDecreaseRatio</code></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>
</div>

<div class="table-container">
    <h3>Usage</h3>
    <h4>JavaScript</h4>
	<pre class="brush: js;">
        o_obj = new myEasyScroll();
        $(document).ready(function(e) {
            o_obj.init({'elementContainer':'#scroll-container'});
        });
        $(window).resize(function(e) {
            o_obj.init({'elementContainer':'#scroll-container'});
        });
    </pre>
    
    <hr />

    <h4>HTML</h4>
	<pre class="brush: php;">
        <div id="scroll-tracker">Optional Element: Shows status. Used in debug mode.</div>
        <div id="scroll-container">
            <div id="scroller">
            	Your content goes here...
            </div>
        </div>
    </pre>
</div>