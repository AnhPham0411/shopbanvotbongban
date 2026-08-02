
// Restore products first to avoid foreign key issues
DB::table('products')->delete();
// Restore categories
DB::table('categories')->delete();

$oldCategories = DB::table('old_categories')->get();
foreach ($oldCategories as $cat) {
    DB::table('categories')->insert((array)$cat);
}

$oldProducts = DB::table('old_products')->get();
foreach ($oldProducts as $prod) {
    DB::table('products')->insert((array)$prod);
}
echo 'Restored from old tables';
