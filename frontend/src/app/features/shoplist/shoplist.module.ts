import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { ShoplistRoutingModule } from './shoplist-routing.module';

import { IngredientsComponent } from './components/ingredients/ingredients.component';
import { IngredientComponent } from './components/ingredient/ingredient.component';
import { ShoplistComponent } from './components/shoplist/shoplist.component';


@NgModule({
  declarations: [

    IngredientsComponent,
    IngredientComponent,
    ShoplistComponent
  ],
  imports: [
    CommonModule,
    ShoplistRoutingModule
  ]
})
export class ShoplistModule { }
