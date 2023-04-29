<?php




function isPublished($isPublished){

return $isPublished ? "published" :"UnPublished";

}

function reversePost($isPublished){


return $isPublished ? "text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800" 
:"focus:outline-none text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:focus:ring-yellow-900";


}


function selectedCategory($id,$categories){

foreach($categories as $category){

    return $category->pivot->category_id ==$id ? "selected":"";
}


}