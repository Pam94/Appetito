import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { ShoplistRoutingModule } from './shoplist-routing.module';

import { ShoplistComponent } from './components/shoplist/shoplist.component';


@NgModule({
  declarations: [
    ShoplistComponent
  ],
  imports: [
    CommonModule,
    ShoplistRoutingModule
  ]
})
export class ShoplistModule { }
