import { ObjectType, Field, Int, registerEnumType } from '@nestjs/graphql';

export enum Status {
  P = 'P',  // Present
  AP = 'AP', // Approved
  L = 'L',  // Late
  A = 'A',  // Absent
}

registerEnumType(Status, {
  name: 'Status',
});

@ObjectType()
export class Attendance {
  @Field()
  session: string;

  @Field(() => Status)
  status: Status;

  @Field(() => Int)
  student_id: number;

  @Field()
  marker: string;
}