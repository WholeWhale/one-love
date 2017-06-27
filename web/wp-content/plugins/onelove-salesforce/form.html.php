<?php if ($error): ?>
  <p class="callout alert">
    <?php echo $email; ?> does not have access to this page.
  </p>
<?php endif; ?>

<p>Enter the email you signed up with to access this page.</p>

<form action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="post">
  <input type="hidden" name="action" value="sf_email_validate" />
  <label for="email">Email Address</label>
  <input type="email" name="email" id="email" required />
  <input type="submit" value="Submit" />
</form>
