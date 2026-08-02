
echo "All Categories in DB:\n";
$cats = DB::table('categories')->get();
foreach($cats as $c) {
    echo "ID: {$c->id}, Name: {$c->category_name}\n";
}
echo "All Products Count: " . DB::table('products')->count() . "\n";
