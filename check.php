
echo "Categories:\n";
$cats = DB::table('categories')->get();
foreach($cats as $c) {
    echo "ID: {$c->id}, Name: {$c->category_name}\n";
}
echo "\nProducts:\n";
$prods = DB::table('products')->take(5)->get();
foreach($prods as $p) {
    echo "ID: {$p->id}, Cat_ID: {$p->category_id}, Name: {$p->name}\n";
}
