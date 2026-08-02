
echo "Old Categories:\n";
$cats = DB::table('old_categories')->get();
foreach($cats as $c) {
    echo "ID: {$c->id}, Name: {$c->category_name}\n";
}
