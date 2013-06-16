<table style="border-collapse:collapse; border: 1px solid #DCDCDC; width: 100%">
	<tr style="background-color:whitesmoke">
		<td>
			{subject} :: {date} :: posted by <b>{user}</b>
		</td>
	</tr>
	<tr>
		<td>
			<p>{news}</p>
			<p>{fullstory}</p>
		</td>
	</tr>
	<tr style="background-color:whitesmoke">
		<th>Comments</th>
	</tr>
	{comments}
	<tr style="background-color:whitesmoke">
		<th style="font-weight:normal">{prev_page|<<< Prev} {pagination} {next_page|Next >>>}</th>
	</tr>
</table>
<p></p>
<table style="border-collapse:collapse; border: 1px solid #DCDCDC; width: 100%">
	<tr style="background-color:whitesmoke">
		<th>Add Comment</th>
	</tr>
	<tr>
		<td align="center">[form]
			<table border="0" cellspacing="0" cellpadding="3" width="100%">
				<tr>
					<td align="right" style="width: 40%">Name</td>
					<td align="left" style="width: 60%">[namefld,20]</td>
				</tr>
				<tr>
					<td align="right">Email</td>
					<td align="left">[mailfld,20] (optional)</td>
				</tr>
				<tr>
					<td colspan="2" align="center">
						:: Comment ::<br />
						[comfld,60,10]
					</td>
				</tr>
				<tr>
					<td align="right">Characters Left</td>
					<td align="left">[comlen]</td>
				</tr>
				<tr>
					<td align="right"> </td>
					<td align="left">[securityimg]</td>
				</tr>
				<tr>
					<td align="right">Security Code</td>
					<td align="left">[securityfld] (copy the security code from the image above)</td>
				</tr>
				<tr>
					<td align="right">Password</td>
					<td align="left">[pwfld,20] (admins only)</td>
				</tr>
				<tr style="background-color:whitesmoke">
					<td colspan="2" align="center">
						[buttons]
					</td>
				</tr>
			</table>
			[/form]
		</td>
	</tr>
</table>