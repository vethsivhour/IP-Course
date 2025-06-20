import { Field, InputType, Int } from "@nestjs/graphql";
import { Status } from "../attendance.entity";

@InputType()
export class MarkAttendanceInput {
  @Field()
  session: string;

  @Field(() => Status)
  status: Status;

  @Field(() => Int)
  student_id: number;

  @Field()
  marker: string;
}