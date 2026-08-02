
$admin = DB::table('users')->where('role', 'admin')->first();
if ($admin) {
    DB::table('users')->where('role', 'admin')->update(['password' => Hash::make('123456')]);
    echo "Admin password reset to 123456\n";
} else {
    echo "Admin not found\n";
}
