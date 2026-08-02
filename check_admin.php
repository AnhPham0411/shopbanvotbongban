
$admin = DB::table('users')->where('role', 'admin')->first();
if ($admin) {
    echo "Admin Email: " . $admin->email . "\n";
    // Also, if it was imported from the old database, the password might be stored exactly as it was, which is plaintext?
    echo "Admin Password (hashed or plain?): " . $admin->password . "\n";
} else {
    echo "No admin found.\n";
}
