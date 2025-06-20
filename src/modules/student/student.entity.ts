import { ObjectType, Field, Int } from '@nestjs/graphql';

@ObjectType()
export class Student {
  @Field(() => Int)
  id: number;

  @Field()
  name: string;

  @Field()
  idCard: string;

  @Field()
  class: string;
}