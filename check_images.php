
$prods = DB::table('products')->take(5)->get();
foreach($prods as $p) {
    echo "ID: {$p->id}, Image: {$p->image}\n";
}
