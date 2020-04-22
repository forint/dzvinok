# magento2-social-sharing


<br/>
<h2> Mannual Installation Instructions</h2>
go to Magento2Project root dir 
create following Directory Structure :<br/>
<strong>/Magento2Project/app/code/Dzvinok/Social</strong>
you can also create by following command:
<pre>
cd /Magento2Project
mkdir app/code/Dzvinok
mkdir app/code/Dzvinok/Social
</pre>



<h3> Enable Dzvinok/Social Module</h3>
to Enable this module you need to follow these steps:

<ul>
<li>
<strong>Enable the Module</strong>
<pre>bin/magento module:enable Dzvinok_Social</pre></li>
<li>
<strong>Run Upgrade Setup</strong>
<pre>bin/magento setup:upgrade</pre></li>
<li>
<strong>Re-Compile (in-case you have compilation enabled)</strong>
	<pre>bin/magento setup:di:compile</pre>
</li>
</ul>
