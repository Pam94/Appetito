import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { ShoplistRoutingModule } from './shoplist-routing.module';

import { ShoplistComponent } from './components/shoplist/shoplist.component';
import { SharedModule } from 'src/app/shared/shared.module';


@NgModule({
  declarations: [
    ShoplistComponent
  ],
  imports: [
    CommonModule,
    SharedModule,
    ShoplistRoutingModule
  ]
})
export class ShoplistModule { }
